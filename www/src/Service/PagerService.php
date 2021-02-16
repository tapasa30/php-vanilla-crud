<?php

namespace Service;

use Model\User;

class PagerService {

    public function buildPagination(int $itemsPerPage, int $currentPage, int $total, string $baseUrl): array {
        $pages = [];
        $firstUrl = null;
        $lastUrl = null;

        for ($i = 1; $i <= $total; $i++) {
            $pages[$i] = [
                'url' => $baseUrl . '&currentPage=' . $i,
                'active' => $currentPage == $i,
                'number' => $i
            ];
        }

        if (sizeof($pages) > 1) {
            $firstUrl = [
                'url' => $baseUrl . '&currentPage=' . reset($pages)['number']
            ];

            $lastUrl = [
                'url' => $baseUrl . '&currentPage=' . end($pages)['number'],
                'number' => end($pages)['number']
            ];
        }

        return [
            'first' => $firstUrl,
            'pages' => $pages,
            'last' => $lastUrl,
            'currentPage' => $currentPage
        ];
    }
}
