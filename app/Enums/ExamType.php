<?php

namespace App\Enums;


enum ExamType: string
{
    case BEHAVIORAL = "behavioral";
    case TECHNICAL = "technical";
    case COGNITIVE = "cognitive";
    case SITUATIONAL = "situational";
    case APTITUDE = "aptitude";
}
