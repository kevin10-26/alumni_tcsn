<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\Survey;
use Alumni\Infrastructure\Entity\SurveyDoctrine;

class SurveyMapper
{
    public function toDomain(SurveyDoctrine $surveyDoctrine): Survey
    {
        return new Survey(
            id: $surveyDoctrine->getId(),
            question: $surveyDoctrine->getQuestion(),
            options: $surveyDoctrine->getOptions(),
            createdAt: $surveyDoctrine->getCreatedAt(),
            expiresAt: $surveyDoctrine->getExpiresAt()
        );
    }

    public function toDoctrine(Survey $survey): SurveyDoctrine
    {
        $surveyDoctrine = new SurveyDoctrine();
        $surveyDoctrine->setQuestion($survey->question);
        $surveyDoctrine->setOptions($survey->options);
        $surveyDoctrine->setCreatedAt($survey->createdAt);
        $surveyDoctrine->setExpiresAt($survey->expiresAt);
        
        return $surveyDoctrine;
    }
}
