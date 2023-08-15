<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ReportListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'to' => ['required', 'numeric', 'min:10', 'max:50'],
            'page' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function getTo(): int
    {
        return intval($this->input('to', 10));
    }

    public function getPage(): int
    {
        return intval($this->input('page', 1));
    }
}
