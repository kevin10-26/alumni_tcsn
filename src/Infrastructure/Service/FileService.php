<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Alumni\Domain\Service\FileServiceInterface;
use Alumni\Domain\Entity\File;

use Alumni\Domain\Repository\DB\AttachmentsRepositoryInterface;

use Alumni\Infrastructure\Repository\File\Mapper\FileMapper;

/**
 * Service implementation for file validation and processing.
 * 
 * This service handles file validation (extension, MIME type, size),
 * file entity conversion, and document extraction from channel post content.
 */
class FileService implements FileServiceInterface
{
    /**
     * Allowed file extensions and their corresponding MIME types.
     * 
     * Organized by file type category: 'picture' for images and 'file' for documents.
     * 
     * @var array<string, array<string, string>>
     */
    const ALLOWED_EXTENSIONS = array(
        'picture' => array(
            "jpg" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "png" => "image/png",
            "webp" => "image/webp"
        ),
        'file' => array(
            "pdf"  => "application/pdf",
            "doc"  => "application/msword",
            "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "odt"  => "application/vnd.oasis.opendocument.text",
            "rtf"  => "application/rtf",
            "txt"  => "text/plain",
            "pages" => "application/vnd.apple.pages",

            // Spreasheets
            "xls"  => "application/vnd.ms-excel",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "ods"  => "application/vnd.oasis.opendocument.spreadsheet",
            "csv"  => "text/csv",

            // Slideshows
            "ppt"  => "application/vnd.ms-powerpoint",
            "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "odp"  => "application/vnd.oasis.opendocument.presentation",
            "key"  => "application/vnd.apple.keynote",

            // Archives
            "zip"  => "application/zip",
            "rar"  => "application/vnd.rar",
            "7z"   => "application/x-7z-compressed",

            // Signatures
            "p7m"  => "application/pkcs7-mime",
            "p7s"  => "application/pkcs7-signature",
            "pem"  => "application/x-pem-file",
            "cer"  => "application/pkix-cert"
        )
    );

    /**
     * Maximum allowed size for picture files (approximately 2 MB).
     */
    private const MAX_PICTURE_SIZE = 2 * 1024 * 1024;

    /**
     * Maximum allowed size for document files (approximately 5 MB).
     */
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    /**
     * Array storing validation check results.
     * 
     * @var array<string, string|bool>
     */
    private array $checkings = array(
        'fileExt' => '',
        'fileType' => '',
        'fileSize' => ''
    );

    /**
     * Creates a new instance of FileService.
     * 
     * @param FileMapper $fileMapper Mapper for converting file entities
     */
    public function __construct(
        private readonly FileMapper $fileMapper,
        private readonly AttachmentsRepositoryInterface $attachmentsRepository
    ) {}

    /**
     * Validates a file based on extension, MIME type, and size.
     * 
     * This method performs three validation checks:
     * 1. File extension must be in the allowed list for the given mode
     * 2. MIME type must match the allowed MIME types for the given mode
     * 3. File size must not exceed the maximum size for the given mode
     * 
     * @param File $file The file entity to validate
     * @param string $mode The validation mode: 'picture' or 'file'
     * @return bool Returns true if all validations pass, false otherwise
     */
    public function isFileValid(File $file, string $mode): bool
    {
        $maxSize = strtolower($mode) === 'picture' ? self::MAX_PICTURE_SIZE : self::MAX_FILE_SIZE;

        $fileExt = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
        $this->checkings['fileExt'] = (in_array($fileExt, array_keys(self::ALLOWED_EXTENSIONS[strtolower($mode)]))) ? true : 'Please choose a valid file extension.';

        $this->checkings['fileType'] = (in_array($file->mimeType, array_values(self::ALLOWED_EXTENSIONS[strtolower($mode)]))) ? true : 'File is not recognized.';

        $this->checkings['fileSize'] = ($file->size <= $maxSize) ? true : 'File size has exceeded the size limit.';

        $isFileValid = array_unique($this->checkings);

        return (count($isFileValid) === 1) ? true : false;
    }

    /**
     * Converts a file object to a File domain entity.
     * 
     * @param object $file The file object to convert
     * @return File The file as a domain entity
     */
    public function getFile(object $file): File
    {
        return $this->fileMapper->toDomain($file);
    }

    /**
     * Extracts documents (files and pictures) from channel post content.
     * 
     * This method processes the content blocks, identifies image and attachment blocks,
     * extracts file information, and updates the content with proper URLs. The original
     * pool location is preserved in a 'poolLocation' field for database storage.
     * 
     * The content array is modified by reference to update URLs and remove filenames.
     * 
     * @param array<string, mixed> $content The channel post content (modified by reference)
     * @param int $channelId The ID of the channel
     * @return array<string, array<int, array<string, mixed>>> Array containing 'files' and 'pictures' arrays with file data
     */
    public function getDocumentsFromChannelPost(array &$content, int $channelId): array
    {
        $documents = array(
            'files' => [],
            'pictures' => []
        );

        foreach($content['blocks'] as $block => $blockContent)
        {
            if(!isset($blockContent['data']['file'])) continue;
            
            $filename = basename($blockContent['data']['file']['url']);

            switch ($blockContent['type'])
            {
                // In any case, replace the url with the future location value (not the pool) for display matters.
                // Keep the pool hash for DB and File repo by creating a new entry in the object (poolLocation).
                // Then, separate the medias from the whole content block, and update the latter with the modified values.
                // In case of a post update, separe existing files by verifying if they exist in their real directory (not in pool)
                case 'image':
                    if (!file_exists($_ENV['APP_DIR'] . "public/img/channels/$channelId/$filename"))
                    {
                        $blockContent['data']['file']['poolLocation'] = $blockContent['data']['file']['url'];
                        $blockContent['data']['file']['url'] = $_ENV['APP_URL'] . 'img/channels/' . $channelId . '/' . $blockContent['data']['file']['name'];
                        unset($blockContent['data']['file']['name']);

                        $content['blocks'][$block] = $blockContent;
                    }

                    $documents['pictures'][] = $blockContent['data']['file'];
                    break;
                
                case 'attaches':
                    if (!file_exists($_ENV['APP_DIR'] . "public/documents/channels/$channelId/$filename"))
                    {
                        $blockContent['data']['file']['poolLocation'] = $blockContent['data']['file']['url'];
                        $blockContent['data']['file']['url'] = $_ENV['APP_URL'] . 'documents/channels/' . $channelId . '/' . $blockContent['data']['file']['name'];
                        unset($blockContent['data']['file']['name']);

                        $content['blocks'][$block] = $blockContent;
                    }

                    $documents['files'][] = $blockContent['data']['file'];
                    break;

                default:
                    // Throw exception.
                    break;
            }
        }

        return $documents;
    }

    /**
     * Gets the added and removed documents from a post's content
     * 
     * This method fetches the existing documents, then retrieves the ones mentionned by the content to update.
     * The goal is to compare which are added / removed, to push / delete them from DB and their destination directory.
     * 
     * @see this getDocumentsFromChannelPost(): to get the documents part of the post to update.
     * 
     * @param array<string, mixed> $content The channel post content (modified by reference)
     * @param int $channelId The ID of the channel
     * @param int $postId The ID of the channel
     * @return array<string, array<int, array<string, mixed>>> Array containing the added and removed arrays with file data
     */
    public function getDocumentsDiff(array &$content, int $channelId, int $postId): array
    {
        $dbDocuments = $this->attachmentsRepository->getPostAttachments($postId, $channelId);

        $updatedPostDocuments = $this->getDocumentsFromChannelPost($content, $channelId);
        $mergedPostDocuments = array_merge($updatedPostDocuments['pictures'], $updatedPostDocuments['files']);

        $updatedPostFilenames = array_column($mergedPostDocuments, 'url');

        $dbFilenames = array_column($dbDocuments, 'filePath');

        $updatedPostFilesStatus = array(
            'newFiles' => $this->getFilenamesKeys(array_diff($updatedPostFilenames, $dbFilenames), $mergedPostDocuments),
            'removedFilesFromPost' => array_diff($dbFilenames, $updatedPostFilenames)
        );
        
        return $updatedPostFilesStatus;
    }

    /**
     * Gets the corresponding pictures entries from a diff.
     * 
     * This method retrieves the entries of param $referencedDocuments (#2) from a set of URL mentionned
     * in param $uploadedPostFilesStatus (#1), to get the file sets that must used to be uploaded on the server.
     * Then, build an array and place the documents whether in 'files' or 'pictures' key.
     * 
     * @see this getDocumentsFromChannelPost() to check the structure of $referencedDocuments param.
     * 
     * @param array $uploadedPostFilesStatus the array of URL uploaded from the UI
     * @param array $referencedDocuments the reference array containing the full entries (with 'url' and 'poolLocation')
     * @return array the corresponding entries of $referencedDocuments param.
     */
    private function getFilenamesKeys(array $uploadedPostFilesStatus, array $referencedDocuments): array
    {
        $documents = array(
            'files' => [],
            'pictures' => []
        );

        foreach($uploadedPostFilesStatus as $document)
        {

            $key = array_search($document, array_column($referencedDocuments, 'url'));
            $entry = $referencedDocuments[$key];

            (preg_match('/\/img\//i', $document)) ? $documents['pictures'][] = $entry : $documents['files'][] = $entry;
        }

        return $documents;
    }
}