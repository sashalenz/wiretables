<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Pagination\Paginator;

trait WithPagination
{
    public int $perPage = 20;
    public bool $simplePagination = false;
    protected static string $pageKey = 'page';

    public function bootWithPagination(): void
    {
        $this->setPage($this->resolvePage());

        Paginator::currentPageResolver(fn () => $this->{self::$pageKey});

        Paginator::defaultView($this->paginationView());
        Paginator::defaultSimpleView($this->simplePaginationView());
    }

    public function queryStringWithPagination(): array
    {
        return [
            self::$pageKey => ['except' => 1],
        ];
    }

    protected function paginationView(): string
    {
        return 'wiretables::partials.pagination';
    }

    protected function simplePaginationView(): string
    {
        return 'wiretables::partials.simple-pagination';
    }

    protected function resetPage(): void
    {
        $this->setPage(1);
    }

    private function resolvePage()
    {
        return $this->getRequest()->query(self::$pageKey, 1);
    }

    private function setPage($page): void
    {
        $this->{self::$pageKey} = (int) $page;
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function previousPage(): void
    {
        if ($this->{self::$pageKey} === 1) {
            return;
        }

        $this->setPage(--$this->{self::$pageKey});
    }

    public function nextPage(): void
    {
        $this->setPage(++$this->{self::$pageKey});
    }
}
