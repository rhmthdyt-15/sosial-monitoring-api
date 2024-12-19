<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class LaporanCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_id' => 'required|exists:bantuan_programs,id',
            'region_id' => 'required|exists:regions,id',
            'jumlah_penerima' => 'required|integer|min:1',
            'tanggal_penyaluran' => 'required|date',
            'bukti_penyaluran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'catatan_tambahan' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('tanggal_penyaluran')) {
            // Ubah format tanggal dari d-m-Y ke Y-m-d
            $this->merge([
                'tanggal_penyaluran' => Carbon::createFromFormat('d-m-Y', $this->tanggal_penyaluran)->format('Y-m-d'),
            ]);
        }
    }
}