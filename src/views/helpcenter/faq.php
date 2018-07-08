<div class="row-container faq-container">
    <h1 class="title" style="padding-top:20px">Support</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">La foire aux questions</h3>

    <div class="faq-sidebar-container">
        <div class="faq-category" data-category="basics">Général</div>
        <div class="faq-category" data-category="games">Jeux</div>
        <div class="faq-category" data-category="editor">Editeur</div>
        <div class="faq-category" data-category="market">Magasin</div>
        <div class="faq-category" data-category="others">Autres</div>
    </div>

    <div class="faq-questions-container">
        <div class="title"></div>

        <div class="faq-questions faq-basics">
            <?php if (isset($d->basics)): foreach ($d->basics as $v): ?>
                <div class="question-container">
                    <div class="question"><?= $v->question ?></div>
                    <i class="fa fa-angle-down toggle-view"></i>

                    <div class="answer"><p><?= $v->answer ?></p></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="faq-questions faq-games">
            <?php if (isset($d->games)): foreach ($d->games as $v): ?>
                <div class="question-container">
                    <div class="question"><?= $v->question ?></div>
                    <i class="fa fa-angle-down toggle-view"></i>

                    <div class="answer"><p><?= $v->answer ?></p></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="faq-questions faq-editor">
            <?php if (isset($d->editor)): foreach ($d->editor as $v): ?>
                <div class="question-container">
                    <div class="question"><?= $v->question ?></div>
                    <i class="fa fa-angle-down toggle-view"></i>

                    <div class="answer"><p><?= $v->answer ?></p></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="faq-questions faq-market">
            <?php if (isset($d->market)): foreach ($d->market as $v): ?>
                <div class="question-container">
                    <div class="question"><?= $v->question ?></div>
                    <i class="fa fa-angle-down toggle-view"></i>

                    <div class="answer"><p><?= $v->answer ?></p></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="faq-questions faq-others">
            <?php if (isset($d->others)): foreach ($d->others as $v): ?>
                <div class="question-container">
                    <div class="question"><?= $v->question ?></div>
                    <i class="fa fa-angle-down toggle-view"></i>

                    <div class="answer"><p><?= $v->answer ?></p></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <div class="clear"></div>

</div>