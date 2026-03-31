<?php

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-card-title {@panel_style} {@!title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove}',
        'uk-margin-remove-top {@title_margin: remove}',
        'uk-margin-remove-bottom',
    ],

]);

// Meta
$meta = $this->el('div', [

    'class' => [
        'el-meta',
        'uk-[text-{@meta_style: meta}]{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove}',
        'uk-margin-remove-bottom {@!meta_style: |meta} [uk-margin-{meta_margin: remove}-top]',
    ],

]);

// Position
$position = $this->el('div', [

    'class' => [
        'el-position',
        'uk-[text-{@position_style: position}]{position_style}',
        'uk-text-{position_color}',
        'uk-margin[-{position_margin}]-top {@!position_margin: remove}',
        'uk-margin-remove-bottom {@!position_style: |position} [uk-margin-{position_margin: remove}-top]',
    ],

]);

// Date
$date = $this->el('div', [

    'class' => [
        'el-date',
        'uk-[text-{@date_style: date}]{date_style}',
        'uk-text-{date_color}',
        'uk-margin[-{date_margin}]-top {@!date_margin: remove}',
        'uk-margin-remove-bottom {@!date_style: |date} [uk-margin-{date_margin: remove}-top]',
    ],

]);

// Talk Tile
$talk_title = $this->el('div', [

    'class' => [
        'el-talk_title',
        'uk-[text-{@talk_title_style: talk_title}]{talk_title_style}',
        
        'uk-text-{talk_title_color}',
        'uk-margin[-{talk_title_margin}]-top {@!talk_title_margin: remove}',
        'uk-margin-remove-bottom {@!talk_title_style: |talk_title} [uk-margin-{talk_title_margin: remove}-top]',
    ],

]);


// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-panel',
        'uk-text-{content_style}',
        '[uk-text-left{@content_align}]',
        'uk-margin[-{content_margin}]-top {@!content_margin: remove}',
    ],

]);

// Tags
$tags = $this->el('div', [

    'class' => [
        'el-tags',
        'uk-[text-{@tags_style: tags}]{tags_style}',
        'uk-text-{tags_color}',
        '[uk-text-left{@tags_align}]',
        'uk-margin[-{date_margin}]-top {@!tags_margin: remove}',
        'uk-margin-remove-bottom {@!tags_style: |tags} [uk-margin-{tags_margin: remove}-top]',
    ],

]);



// Link
$link_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_margin}]-top {@!link_margin: remove}',
    ],

]);

// Title Grid
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $element['title_grid_column_gap'] == $element['title_grid_row_gap'] ? 'uk-grid-{title_grid_column_gap}' : '[uk-grid-column-{title_grid_column_gap}] [uk-grid-row-{title_grid_row_gap}]',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove} {@image_align: top}' => !$props['meta'] || $element['meta_align'] != 'above-title',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove} {@image_align: top} {@meta_align: above-title}' => $props['meta'],
    ],

    'uk-grid' => true,
]);

$cell_title = $this->el('div', [

    'class' => [
        'uk-width-{title_grid_width}[@{title_grid_breakpoint}]',
        'uk-margin-remove-first-child',
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child',
    ],

]);

?>

<?php if ($props['title'] && $element['title_align'] == 'left') : ?>
<?= $grid($element) ?>
    <?= $cell_title($element) ?>
<?php endif ?>

        <?php if ($props['meta'] && $element['meta_align'] == 'above-title') : ?>
        <?= $meta($element, $props['meta']) ?>
        <?php endif ?>

        <?php if ($props['tags'] && $element['tags_align'] == 'above-title') : ?>
        <?= $tags($element, $props['tags']) ?>
        <?php endif ?>

        <?php if ($props['position'] && $element['position_align'] == 'above-title') : ?>
        <?= $position($element, $props['position']) ?>
        <?php endif ?>

        <?php if ($props['date'] && $element['date_align'] == 'above-title') : ?>
        <?= $date($element, $props['date']) ?>
        <?php endif ?>

        <?php if ($props['talk_title'] && $element['talk_title_align'] == 'above-title') : ?>
        <?= $talk_title($element, $props['talk_title']) ?>
        <?php endif ?>

        <?php if ($props['title']) : ?>
        <?= $title($element) ?>
            <?php if ($element['title_color'] == 'background') : ?>
            <span class="uk-text-background"><?= $props['title'] ?></span>
            <?php elseif ($element['title_decoration'] == 'line') : ?>
            <span><?= $props['title'] ?></span>
            <?php else : ?>
            <?= $props['title'] ?>
            <?php endif ?>
        <?= $title->end() ?>
        <?php endif ?>

        <?php if ($props['meta'] && $element['meta_align'] == 'below-title') : ?>
        <?= $meta($element, $props['meta']) ?>
        <?php endif ?>
            
        <?php if ($props['tags'] && $element['tags_align'] == 'below-title') : ?>
        <?= $tags($element, $props['tags']) ?>
        <?php endif ?>
            
        <?php if ($props['position'] && $element['position_align'] == 'below-title') : ?>
        <?= $position($element, $props['position']) ?>
        <?php endif ?>    
            
        <?php if ($props['date'] && $element['date_align'] == 'below-title') : ?>
        <?= $date($element, $props['date']) ?>
        <?php endif ?>    

        <?php if ($props['talk_title'] && $element['talk_title_align'] == 'below-title') : ?>
        <?= $talk_title($element, $props['talk_title']) ?>
        <?php endif ?>
            
        <?php if ($props['title'] && $element['title_align'] == 'left') : ?>
        <?= $cell_title->end() ?>
        <?= $cell_content($element) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'between') : ?>
        <?= $props['image'] ?>
        <?php endif ?>

        <?php if ($props['meta'] && $element['meta_align'] == 'above-content') : ?>
        <?= $meta($element, $props['meta']) ?>
        <?php endif ?>
            
        <?php if ($props['talk_title'] && $element['talk_title_align'] == 'above-content') : ?>
        <?= $talk_title($element, $props['talk_title']) ?>
        <?php endif ?>

        <?php if ($props['date'] && $element['date_align'] == 'above-content') : ?>
        <?= $date($element, $props['date']) ?>
        <?php endif ?>
            
        <?php if ($props['tags'] && $element['tags_align'] == 'above-content') : ?>
        <?= $tags($element, $props['tags']) ?>
        <?php endif ?>
         
        <?php if ($props['position'] && $element['position_align'] == 'above-content') : ?>
        <?= $position($element, $props['position']) ?>
        <?php endif ?>    
            
        <?php if ($props['content']) : ?>
        <?= $content($element, $props['content']) ?>
        <?php endif ?>

        <?php if ($props['meta'] && $element['meta_align'] == 'below-content') : ?>
        <?= $meta($element, $props['meta']) ?>
        <?php endif ?>
            
        <?php if ($props['tags'] && $element['tags_align'] == 'below-content') : ?>
        <?= $tags($element, $props['tags']) ?>
        <?php endif ?>
            
        <?php if ($props['talk_title'] && $element['talk_title_align'] == 'below-content') : ?>
        <?= $talk_title($element, $props['talk_title']) ?>
        <?php endif ?>
          
        <?php if ($props['position'] && $element['position_align'] == 'below-content') : ?>
        <?= $position($element, $props['position']) ?>
        <?php endif ?>
            
        <?php if ($props['date'] && $element['date_align'] == 'below-content') : ?>
        <?= $date($element, $props['date']) ?>
        <?php endif ?>

        <?php if ($props['link'] && $element['link_text']) : ?>
        <?= $link_container($element, $link($element, $element['link_text'])) ?>
        <?php endif ?>

<?php if ($props['title'] && $element['title_align'] == 'left') : ?>
    <?= $cell_content->end() ?>
<?= $grid->end() ?>
<?php endif ?>