<?php

namespace App\Support;

class MemberContentModerator
{
    /**
     * @var list<string>
     */
    private const BLOCKED_TERMS = [
        'arse',
        'asshole',
        'bastard',
        'bitch',
        'bollocks',
        'bullshit',
        'crap',
        'cunt',
        'damn',
        'dick',
        'fuck',
        'motherfucker',
        'piss',
        'prick',
        'shit',
        'slut',
        'twat',
        'wanker',
    ];

    public static function containsBlockedLanguage(?string $content): bool
    {
        $content = strtolower($content ?? '');

        foreach (self::BLOCKED_TERMS as $term) {
            if (preg_match('/\b'.preg_quote($term, '/').'\b/i', $content) === 1) {
                return true;
            }
        }

        return false;
    }
}
