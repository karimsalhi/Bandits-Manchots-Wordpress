<?php
class BanditManchot
{
    public array $templatesValues;
    public array $templates;
    public string $type;
    public int $bestTemplate;

    public function getValue(int $success, int $template) :int
    {
        $value = $this->templates[$template];
        $template = $this->templates[$template];
        $newValue = $value + ((1 / ($template + 1)) * ($success - $value));
        $this->templatesValues[$template] = $newValue;
        $this->templates[$template] += 1;
        return $newValue;
    }

    public function geType (): void
    {
        $values = 0;
        foreach ($this->templates as $key => $value) {
            $values += $value;
        }

        if (($this->type == "exploration" && $values % 50 == 0) or ($this->type == "exploitation" && $values % 450 == 0)) {
            $this->type = "exploitation";
        }
    }

    public function getBestTemplate (): void
    {
        $previousVal = 0;
        foreach ($this->templates as $key => $value) {
            if ($value > $previousVal) {
                $this->bestTemplate = $key;
                $previousVal = $value;
            }
        }
    }
}
