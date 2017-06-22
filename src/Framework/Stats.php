<?php

namespace June\Framework;

class Stats
{
    public $failed = 0;
    public $passed = 0;
    public $regressions = 0;
    public $skipped = 0;
    public $tests = 0;

    public function record(Test $test): void
    {
        $test->isSkipped() ? $this->skipped() : $this->ran($test);
    }

    protected function failed(Test $test): void
    {
        $test->isBug() ? $this->regressions++ : $this->failed++;
    }

    protected function ran(Test $test): void
    {
        $this->tests++;
        
        $test->success ? $this->passed++ : $this->failed($test);
    }

    protected function skipped(): void
    {
        $this->skipped++;
    }
}
