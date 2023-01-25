<?php

class ViewData
{
    /**
     * @var int $time
     */
    private $time;

    /**
     * @var float $distance
     */
    private $distance;

    const SPEED_PRECISION = 2;

    public function __construct()
    {
        $this->time = $_POST['time'];
        $this->distance = $_POST['distance'];
    }

    /**
     * @return int
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @return float
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * @return bool
     */
    public function hasSentData(): bool
    {
        return isset($this->time) && isset($this->distance);
    }

    /**
     * @return string
     */
    public function getAveragePace(): string
    {
        return $this->decimalToMinuteString($this->time / $this->distance);
    }

    /**
     * @return string
     */
    public function getAverageSpeed(): string
    {
        return round($this->distance / ($this->time / 60), self::SPEED_PRECISION);
    }

    /**
     * @param float $timeAsDecimal
     * @return string
     */
    private function decimalToMinuteString(float $timeAsDecimal): string
    {
        $whole = floor($timeAsDecimal);
        $decimal = $timeAsDecimal - $whole;
        $roundedMinutes = round($decimal * 60, 0);
        $minutes = str_pad($roundedMinutes, 2, "0", STR_PAD_LEFT);

        return "{$whole}:{$minutes}";
    }
}
