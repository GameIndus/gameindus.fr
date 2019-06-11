/*
* GameIndus - A free online platform to imagine, create and publish your game with ease!
*
* GameIndus website
* Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
* <https://github.com/GameIndus/gameindus.fr>
*/

function widthSwapper() {
    this.elements = new NodeList();

    this.elementWidth = -1;
}

widthSwapper.prototype = {

    bind: function (nodeList) {
        this.elements = nodeList;
        this.init();

        return this;
    },

    init: function () {
        if (this.elements.length == 0) return false;

        // this.elementWidth =
    }

};