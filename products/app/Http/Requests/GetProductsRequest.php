<?php

namespace App\Http\Requests;

class GetProductsRequest extends ApiFormRequest
{
    public function getSortBy(): ?string
    {
        return $this->input('sortBy');
    }

    public function getSortDirection(): ?string
    {
        return $this->input('sortDirection');
    }

    public function getSearchTerm(): ?string
    {
        return $this->input('q');
    }

    public function rules()
    {
        return [
            'sortBy' => 'required_with:sortDirection|string',
            'sortDirection' => 'required_with:sortBy|string|in:asc,desc',
            'searchTerm' => 'sometimes|required|string',
        ];
    }
}
