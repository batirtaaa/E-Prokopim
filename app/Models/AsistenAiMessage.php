<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsistenAiMessage extends Model
{
    protected $table = 'asisten_ai_messages';

    protected $fillable = [
        'user_id',
        'session_id',
        'role',
        'content',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'structured_data',
    ];

    protected $casts = [
        'structured_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsImageAttribute(): bool
    {
        return in_array(strtolower($this->file_type), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    }

    public function getIsVideoAttribute(): bool
    {
        return in_array(strtolower($this->file_type), ['mp4', 'mov', 'avi', 'mkv', 'webm']);
    }

    public function getIsPdfAttribute(): bool
    {
        return strtolower($this->file_type) === 'pdf';
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return '';
        if ($this->file_size < 1024) return $this->file_size . ' B';
        if ($this->file_size < 1048576) return round($this->file_size / 1024, 1) . ' KB';
        return round($this->file_size / 1048576, 2) . ' MB';
    }

    public function getFormattedContentAttribute(): string
    {
        return static::formatText($this->content);
    }

    public static function formatText(?string $text): string
    {
        if (!$text) return '';

        // Normalize newlines
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        // 1. Convert ***bold italic*** to <strong><em>...</em></strong>
        $text = preg_replace('/\*\*\*(.*?)\*\*\*/s', '<strong><em>$1</em></strong>', $text);

        // 2. Convert **bold** to <strong>...</strong>
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);

        // 3. Convert *italic* to <em>...</em>
        $text = preg_replace('/\*([^\*\n]+)\*/s', '<em>$1</em>', $text);

        // 4. Remove any remaining orphan * characters
        $text = str_replace('*', '', $text);

        // 5. Convert markdown headers ### to strong
        $text = preg_replace('/^### (.*)$/m', '<strong style="display:block; margin:6px 0 2px 0;">$1</strong>', $text);
        $text = preg_replace('/^## (.*)$/m', '<strong style="display:block; margin:8px 0 3px 0; font-size:14px;">$1</strong>', $text);
        $text = preg_replace('/^# (.*)$/m', '<strong style="display:block; margin:10px 0 4px 0; font-size:15px;">$1</strong>', $text);

        // 6. Convert horizontal rules ---
        $text = preg_replace('/^---+$/m', '<hr style="border:none; border-top:1px solid #dbeafe; margin:8px 0;">', $text);

        // 7. Clean bullet points
        $text = preg_replace('/^[•\-\*]\s+/m', '• ', $text);

        // 8. Format into clean compact paragraphs without excessive gap
        $paragraphs = preg_split("/\n\n+/", trim($text));
        $formatted = [];
        foreach ($paragraphs as $p) {
            $p = trim($p);
            if ($p !== '') {
                $formatted[] = '<p style="margin:0 0 6px 0; line-height:1.5;">' . nl2br($p) . '</p>';
            }
        }

        return implode('', $formatted) ?: nl2br(trim($text));
    }
}
