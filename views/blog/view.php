<div class="row-container blog-container blog-post-container">

    <div class="blog-post">
        <h1 class="title grey" style="font-size:1.8em"><?= $d->title; ?></h1>
        <p class="post-meta">par <img src="<?= BASE . trim($d->author->avatar, '/'); ?>" height="24" width="24"
                                      style="top:5px;position:relative"
                                      alt="Avatar de <?= $d->author->username ?>"> <?= $d->author->username ?>
            le <?= date("d/m/Y", strtotime($d->date)); ?> &nbsp;&nbsp;&nbsp; <i class="fa fa-eye"></i>
            vu <?= $d->views + 1 ?> fois</p>

        <br><br>

        <div class="blog-post-content"><?= nl2br($d->content); ?></div>
    </div>

    <div class="blog-sidebar">
        <h1 class="title grey" style="font-size:1.2em">Articles <b>liés</b></h1>
        <hr class="grey" style="margin-top:-15px">

        <div class="blog-articles" style="float:none;width:100%">
            <?php foreach ($d->otherPosts as $v): ?>
                <div class="blog-article blog-popular-article" style="margin:10px 0;width:100%;float:none;height:auto">
                    <div class="article-content" style="width:100%;height:100%">
                        <span class="title" style="font-size:1.1em"><?= $v->title; ?></span>
                        <br>
                        <a href="<?= BASE ?>blog/<?= nameToSlug($v->id, $v->title); ?>/" title="Voir l'article >">
                            <div class="readmore" style="bottom:18px">Voir l'article &nbsp;<i
                                        class="fa fa-angle-right"></i></div>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if (count($d->otherPosts) == 0): ?>
                <p style="padding:15px 10px">Aucun article lié.</p>
            <?php endif; ?>

            <div class="clear"></div>
        </div>
    </div>

    <div class="clear"></div>

</div>