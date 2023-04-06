<?php

namespace Lexxsoft\Upbasis\Support\Traits;

trait ConsoleOutputTrait
{
    private string $msg = '';

    private function process(string $name, int $level = 0): void
    {
        if ($level != 0) {
            $this->currentProcessName = '<fg=gray>';
            $this->currentProcessName .= str_repeat('....', $level);
            $this->currentProcessName .= '</>';
            $this->currentProcessName .= $name;
        } else {
            $this->currentProcessName = $name;
        }
        $this->components->twoColumnDetail($this->currentProcessName, '<fg=yellow;options=bold>Running</>');
    }

    private function processDone(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=green;options=bold>DONE</>');
    }

    private function processFail(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=red;options=bold>FAIL</>');
    }

    private function processSkip(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=yellow;options=bold>SKIP</>');
    }

    private function processPartial(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=yellow;options=bold>Partial</>');
    }

    private function processSub(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=green;options=bold>[SUB]</>');
    }

    private function processExist(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(), '<fg=yellow;options=bold>Exist</>');
    }

    private function processInstalling(): void
    {
        $this->onSameLine();
        $this->components->twoColumnDetail($this->getProcessText(false), '<fg=yellow;options=bold>Installing</>');
    }

    private function getProcessText(bool $clear = true): string
    {
        $first = $this->currentProcessName;
        if (!empty($this->msg)) {
            $first .= "<fg=gray>.</>";
            $first .= "<fg=blue>$this->msg</>";
        }
        if ($clear) {
            $this->currentProcessName = '';
            $this->msg = '';
        }
        return $first;
    }

    private function onSameLine(): void
    {
        $this->moveToColumn(1);
        $this->clearLine();
        $this->moveUp();
    }

    private function clearLine(): void
    {
        $this->output->write("\x1b[2K");
    }

    private function moveToColumn(int $column): void
    {
        $this->output->write(sprintf("\x1b[%dG", $column));
    }

    private function moveUp(int $lines = 1): void
    {
        $this->output->write(sprintf("\x1b[%dA", $lines));
    }
}
