<?php

namespace App\Imports;

use App\Question;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        return new Question([
            'title'  => $row['title'],
            'option_one' => $row['option_one'],
            'option_two' => $row['option_two'],
            'option_three' => $row['option_three'],
            'option_four' => $row['option_four'],
            'point' => $row['point'],
            'answer' => $row['answer'],
            'quiz_id' => session()->get('quiz_id')
        ]);
    }
}
