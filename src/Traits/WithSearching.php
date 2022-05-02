<?php

namespace Sashalenz\Wiretables\Traits;

trait WithSearching
{
    public bool $disableSearch = false;
    protected static string $searchKey = 'search';

    public function bootWithSearching(): void
    {
        $this->setSearch($this->resolveSearch());
    }

    public function queryStringWithSearching(): array
    {
        return [
            self::$searchKey => ['except' => ''],
        ];
    }

    protected function resetSearch(): void
    {
        $this->setSearch('');
    }

    private function resolveSearch()
    {
        return $this->getRequest()->query(self::$searchKey, '');
    }

    private function setSearch($search): void
    {
        $this->{self::$searchKey} = (string) $search;
    }

    public function searchBy($search): void
    {
        $this->setSearch($search);

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getSearchProperty(): string
    {
        return $this->{self::$searchKey};
    }
}
