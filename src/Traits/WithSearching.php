<?php

namespace Sashalenz\Wiretables\Traits;

trait WithSearching
{
    public string $search = '';
    public bool $disableSearch = false;
    public bool $disableStrict = false;
    public bool $strict = false;
    protected static string $searchKey = 'search';

    public function bootWithSearching(): void
    {

    }

    public function queryStringWithSearching(): array
    {
        return [
            'search' => [
                'except' => '',
                'as' => self::$searchKey,
            ],
        ];
    }

    protected function resetSearch(): void
    {
        $this->setSearch('');
    }

    private function setSearch($search): void
    {
        $this->search = (string) $search;
    }

    public function searchBy($search): void
    {
        $this->setSearch($search);

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }
}
