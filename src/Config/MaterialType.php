<?php
 namespace App\Config;

enum MaterialType: string
{
    case practice_questions = "practice questions";
    case flashcards = "flashcards";
    case summary = "summary";

    case lecture ="lecture";
    case lab ="lab";

}