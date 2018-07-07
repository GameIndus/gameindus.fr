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