<?php
/*
 * This file is part of the Hierarchy package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\Hierarchy\Branch;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Hierarchy
 */
final class BranchAttachment implements BranchInterface
{
    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @inheritdoc
     */
    public function name()
    {
        return 'attachment';
    }

    /**
     * @inheritdoc
     */
    public function is(\WP_Query $query)
    {
        if ($query->is_attachment()) {
            $posts = $query->posts;
            $this->post = $posts ? reset($posts) : null;

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function leaves()
    {
        if (! $this->post instanceof \WP_Post) {
            return ['attachment'];
        }
        $leaves = [];
        $mimetype = explode('/', $this->post->post_mime_type, 2);
        if (! empty($mimetype) && ! empty($mimetype[0])) {
            $leaves = isset($mimetype[1]) && $mimetype[1]
                ? [$mimetype[0], $mimetype[1], "{$mimetype[0]}_{$mimetype[1]}"]
                : [$mimetype[0]];
        }

        $leaves[] = 'attachment';

        return $leaves;
    }
}