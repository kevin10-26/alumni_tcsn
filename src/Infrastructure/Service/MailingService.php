<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use \Mailjet\Client;
use \Mailjet\Resources;
use Alumni\Domain\Service\MailingServiceInterface;
use Exception;

class MailingService implements MailingServiceInterface
{
    public function __construct(
        private readonly Client $mailer,
        private readonly int $timeout = 30 // seconds
    ) {
        // Configures timeout for v3.1 Mailjet
        $this->mailer->setTimeout(5);
    }

    /**
     * Sends an email with Mailjet V3.1
     */
    public function send(string $body, string $to, array $flags = []): bool
    {
        try {
            $payload = $this->bodyBuilder(
                subject: $flags['subject'] ?? 'Sans objet',
                body: $body,
                cleanBody: $body,
                to: $to,
                attachments: $flags['attachments'] ?? []
            );

            $response = $this->mailer->post(Resources::$Email, ['body' => $payload]);

            if ($response->success()) {
                // debug : display mailjet data
                // var_dump($response->getData());
                return true;
            } else {
                // Complete debug
                echo "Erreur Mailjet :\n";
                var_dump(
                    $response->getStatus(),
                    $response->getReasonPhrase(),
                    $response->getBody()
                );
                return false;
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
            return false;
        }
    }

    /**
     * Builds payload for Mailjet v3.1
     */
    private function bodyBuilder(
        string $subject,
        string $body,
        string $cleanBody,
        string $to,
        ?array $attachments = []
    ): array {
        $payload = [
            'Messages' => [[
                'From' => [
                    'Email' => $_ENV['MAIL_SENDER_ADDRESS'],
                    'Name'  => 'Alumni TCSN',
                ],
                'To' => [
                    ['Email' => $to]
                ],
                'Subject' => mb_encode_mimeheader($subject, 'UTF-8', 'B'),
                'TextPart' => mb_convert_encoding($body, 'UTF-8', 'auto'),
                'HTMLPart' => mb_convert_encoding($cleanBody, 'UTF-8', 'auto'),
                'Attachments' => $this->buildMailAttachments($attachments)
            ]]
        ];

        $builtAttachments = $this->buildMailAttachments($attachments);
        if (!empty($builtAttachments)) {
            $payload['Messages'][0]['Attachments'] = $builtAttachments;
        }

        return $payload;
    }

    /**
     * Encodes files in base64 Mailjet V3.1
     */
    private function buildMailAttachments(array $attachments): array
    {
        $mailAttachments = [];

        foreach ($attachments as $attachment) {
            if (!is_file($attachment)) {
                continue;
            }

            $mailAttachments[] = [
                'ContentType'   => mime_content_type($attachment),
                'Filename'      => basename($attachment),
                'Base64Content' => base64_encode(file_get_contents($attachment))
            ];
        }

        return $mailAttachments;
    }
}