<?php

namespace AppBundle\Game;

class GameStatus
{
    /**
     * @var integer
     */
    protected $experience;
    /**
     * @var integer
     */
    protected $animalsKilled;
    /**
     * @var integer
     */
    protected $peasantsKilled;
    /**
     * @var integer
     */
    protected $monstersKilled;
    /**
     * @var bool
     */
    protected $isFinished;

    /**
     * @param int $experience
     * @param int $peasantsKilled
     * @param int $animalsKilled
     * @param int $monstersKilled
     * @param bool $isFinished
     */
    public function __construct(
        int $experience,
        int $peasantsKilled,
        int $animalsKilled,
        int $monstersKilled,
        bool $isFinished
    ) {
        $this->experience = $experience;
        $this->animalsKilled = $animalsKilled;
        $this->peasantsKilled = $peasantsKilled;
        $this->monstersKilled = $monstersKilled;
        $this->isFinished = $isFinished;
    }
}
