<?php

namespace Framework\Services;

use Framework\DAOs\DesksDAO;

class DeskService
{
    private DesksDAO $desksDAO;

    public function __construct()
    {
        $this->desksDAO = container(DesksDAO::class);
    }

    public function getDesks(): array
    {
        return $this->desksDAO->selectAll();
    }

    public function getDeskName(int $deskID): string
    {
        return $this->desksDAO::selectById($deskID)['code'];
    }
}