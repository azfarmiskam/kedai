<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CaptchaService
{
    /**
     * Generate a new math captcha question
     *
     * @return string The captcha question (e.g., "5 + 3")
     */
    public static function generate(): string
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operator = ['+', '-'][rand(0, 1)];
        
        $question = "$num1 $operator $num2";
        $answer = $operator === '+' ? $num1 + $num2 : $num1 - $num2;
        
        Session::put('captcha_answer', $answer);
        
        return $question;
    }
    
    /**
     * Validate the user's captcha answer
     *
     * @param mixed $userAnswer The user's answer
     * @return bool True if correct, false otherwise
     */
    public static function validate($userAnswer): bool
    {
        $correctAnswer = Session::get('captcha_answer');
        Session::forget('captcha_answer');
        
        return (int)$userAnswer === (int)$correctAnswer;
    }
}
