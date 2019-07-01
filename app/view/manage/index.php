<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Manage Content</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <h2>Pages</h2>
            <ul class="object-list">
                <?php foreach ( $pages as $page ){ ?>
                <li>
                    <a href="/manage/page/<?php echo $page->idpages; ?>"><?php echo $page->title; ?></a>
                </li>
                <?php  } ?>
            </ul>
        </div>
        
        <div class="col-md-4">
            <h2>Slides (EN)</h2>
            <ul class="object-list">
                <?php foreach ( $slides_en as $slide ){ ?>
                <li>
                    <?php echo $slide->step . '.' . $slide->position; ?> <a href="/manage/slide/<?php echo $slide->step; ?>/<?php echo $slide->position; ?>"><?php echo $slide->title; ?></a>
                </li>
                <?php  } ?>
            </ul>
        </div>
        <div class="col-md-4">
            <h2>Slides (ES)</h2>
            <ul class="object-list">
                <?php foreach ( $slides_es as $slide ){ ?>
                    <li>
                        <?php echo $slide->step . '.' . $slide->position; ?> <a href="/manage/slide/<?php echo $slide->step; ?>/<?php echo $slide->position; ?>/es"><?php echo $slide->title; ?></a>
                    </li>
                <?php  } ?>
            </ul>
        </div>
        
    </div>
</div>