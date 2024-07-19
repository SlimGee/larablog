<?php

namespace App\Enums\Post;

enum Status: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
}
