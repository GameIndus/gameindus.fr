<div class="row-container blog-container">
    <h1 class="title" style="padding-top:20px">Blog</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Toutes les actualités de GameIndus</h3>

    <div class="blog-articles">
        <?php foreach ($d->posts as $v): ?>
            <div class="blog-article">
                <div class="left-date">
                    <span class="date-number"><?= date("j", strtotime($v->date)); ?></span>
                    <span class="date-month"><?= ucfirst(mb_substr(trim(strftime("%B", strtotime($v->date))), 0, 3, "UTF-8")); ?></span>
                </div>
                <div class="article-content">
                    <span class="title"><?= $v->title; ?></span>
                    <p><?= cutText(nl2br($v->content), 700); ?></p>

                    <a href="<?= BASE ?>blog/<?= $v->id ?>" title="Lire plus >">
                        <div class="readmore">Lire plus &nbsp;<i class="fa fa-angle-right"></i></div>
                    </a>
                </div>
            </div>
        <?php endforeach ?>

        <div class="clear"></div>
    </div>

    <div class="blog-sidebar">
        <h1 class="title grey" style="font-size:1.2em">Articles <b>populaires</b></h1>
        <hr class="grey" style="margin-top:-15px">

        <div class="blog-articles" style="float:none;width:100%">
            <?php foreach ($d->popuPosts as $v): ?>
                <div class="blog-article blog-popular-article" style="margin:10px 0;width:100%;float:none;height:auto">
                    <div class="article-content" style="width:100%;height:100%">
                        <span class="title" style="font-size:1.1em"><?= $v->title; ?></span>
                        <br>
                        <p style="color:#656565;font-size:0.95em"><i class="fa fa-eye"></i> <?= $v->views ?>
                            vue<?= ($v->views > 1) ? "s" : ""; ?></p>
                        <a href="<?= BASE ?>blog/<?= nameToSlug($v->id, $v->title); ?>/" title="Voir l'article >">
                            <div class="readmore" style="bottom:18px">Voir l'article &nbsp;<i
                                        class="fa fa-angle-right"></i></div>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>

            <div class="clear"></div>
        </div>
    </div>

    <div class="clear"></div>

</div>