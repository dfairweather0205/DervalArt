var magicTool = function(element) {
    

    this.el = document.querySelector(element);
    if (this.el == null) {
        return;
    }
    this.src = this.el.getAttribute('src');
    this.width = this.el.innderWidth;
    this.height = this.el.innderHeight;

    this.createMagic();
    this.getSrc();
    return this;
}

magicTool.prototype.createMagic = function() {
    var zoomEl = document.createElement('img');
    zoomEl.id = 'big-img';
    zoomEl.setAttribute('src',this.src);
    this.el.parentElement.appendChild(zoomEl);
}

magicTool.prototype.getSrc = function() {
    this.el.addEventListener('mousemove',function(e) {
        var magicImg = document.querySelector('#big-img'),
            mouseX = e.clientX,
            mouseY = e.clientY,
            screenWidth = window.innerWidth,
            screenheight = window.innerHeight,
            imgWidth = this.offsetWidth,
            imgHeight = this.offsetHeight,
            left = mouseX - ((screenWidth - imgWidth) / 2),
            topY = mouseY - ((screenheight - imgHeight) / 2),
            magicImgWidth = magicImg.offsetWidth,
            magicImgHeight = magicImg.offsetHeight,
            xPercent = left / imgWidth * 100 - (imgWidth / magicImgWidth * 100),
            yPercent = topY / imgHeight * 100 - (imgHeight / magicImgHeight * 100);

        magicImg.setAttribute('src',this.getAttribute('src'));
        this.style.opacity = 0;
        magicImg.style.opacity = 1;
        if(xPercent > 50) {
            xPercent = left / imgWidth * 100 - (imgWidth / magicImgWidth * 100);
        } 
        if(yPercent >= 50) {
            yPercent = topY / imgHeight * 100 - (imgHeight / magicImgHeight * 100);
        } 
        if(xPercent <= 0) {
            xPercent = 0;
        } 
        if(yPercent <= 0) {
            yPercent = 0;
        } 
        magicImg.style.transform = 'translate(-'+xPercent+'%,-'+yPercent+'%)';
    });

    this.el.addEventListener('mouseout',function() {
        this.style.opacity = 1;
        document.getElementById('big-img').style.opacity = 0;
    });
}



var magic = new magicTool('.is-magic');



$(document).ready(function() {
    'use strict'

    if($('#product-data').length > 0) {
        const productData = JSON.parse($('#product-data').text());
        const dataType = $('#product-data').data('type');
        var selected = '';
        console.log(productData);
        if(dataType === 'single-product') {
            const productName = productData['post_title'];
            $('select.product-name').append('<option value="'+productName+'" selected>'+productName+'</option>');
        } else {
            productData.forEach(function(item) {
                const productName = item['post_title'];
                $('select.product-name').append('<option value="'+productName+'" '+selected+'>'+productName+'</option>');
             });
        }

    }
});