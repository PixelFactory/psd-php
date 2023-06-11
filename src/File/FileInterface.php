<?php

namespace Psd\File;

interface FileInterface
{
    public function tell(): int;

    public function read(int $length): string;

    public function ffseek(int $amt, bool $rel = false): int;

    public function readString(int $length): string;

    public function readUnicodeString(int $length): string;

    public function readByte();

    public function readBytes($size, callable $func = null): array;

    public function readBoolean(): bool;

    public function readSpaceColor(): array;

    public function readPathNumber(): float;

    public function readInt(): int;

    public function readUInt(): int;

    public function readShort(): int;

    public function readUShort(): int;

    public function readFloat(): float;

    public function readDouble(): float;

    public function readLongLong(): int;

    public function readIntLE(): int;
}
