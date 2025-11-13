<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\AttachmentReport;
use Alumni\Domain\Entity\Report;
use Alumni\Infrastructure\Entity\AttachmentsReportDoctrine;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

class AttachmentsReportMapper
{
    /**
     * ✅ OPTION 1 : Garder les 2 paramètres (si AttachmentReport a besoin du Report)
     */
    public function toDomain(
        AttachmentsReportDoctrine $attachmentDoctrine,
        Report $report
    ): AttachmentReport {
        return new AttachmentReport(
            id: $attachmentDoctrine->getId(),
            filename: $attachmentDoctrine->getFilename(),
            mimeType: $attachmentDoctrine->getMimeType(),
            fileSize: $attachmentDoctrine->getFileSize(),
            uploadedAt: $attachmentDoctrine->getUploadedAt(),
            report: $report
        );
    }

    public function toDoctrine(
        AttachmentReport $attachmentReport,
        ReportsDoctrine $report
    ): AttachmentsReportDoctrine {
        $attachmentDoctrine = new AttachmentsReportDoctrine();
        $attachmentDoctrine->setFilename($attachmentReport->filename);
        $attachmentDoctrine->setMimeType($attachmentReport->mimeType);
        $attachmentDoctrine->setFileSize($attachmentReport->fileSize);
        $attachmentDoctrine->setUploadedAt($attachmentReport->uploadedAt);
        $attachmentDoctrine->setReport($report); // ✅ Correction : setReport (pas setReportId)
        
        return $attachmentDoctrine;
    }
}