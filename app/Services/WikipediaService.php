<?php

namespace App\Services;

class WikipediaService
{
    /**
     * @TODO
     * @param string $url
     * @return array
     */
    public function getPageLinks(string $url): array
    {
        return [];
    }

    /**
     * @TODO: дописать поиск ссылок на статьи вики
     * @param string $pageId
     * @return array
     */
    private function parsePage(string $pageId): array
    {
        $content = $this->getPageContentById($pageId);
        $mathes = [];

//        preg_match_all('/<a href="\/wiki\/(.*)"/')
    }

    public function getRandomPageId(int $count = 1): array
    {
        $output = [];
        try {
            $content = file_get_contents("https://en.wikipedia.org/w/api.php?format=json&action=query&generator=random&grnnamespace=0&rvprop=content&grnlimit={$count}");
            $arrayData = json_decode($content, true);

            if (isset($arrayData['query']['pages'])) {
                $output = $arrayData['query']['pages'];
            }
        } catch (\Exception $e) {

        }

        return array_keys($output);
    }

    private function getPageContentById(string $pageId): string
    {
        try {
            $content = file_get_contents("https://en.wikipedia.org/w/api.php?action=parse&pageid={$pageId}&prop=text&formatversion=2&format=json");
            $data = json_decode($content, true);
            $output = $data['text'];
        } catch (\Exception $e) {
            $output = '';
        }

        return $output;
    }
}