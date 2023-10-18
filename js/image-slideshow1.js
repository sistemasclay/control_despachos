   	/***********************************************************************************************
	
	Copyright (c) 2005 - Alf Magne Kalleland post@dhtmlgoodies.com
	
	UPDATE LOG:
	
	March, 10th, 2006 : Added support for a message while large image is loading
	
	Get this and other scripts at www.dhtmlgoodies.com
	
	You can use this script freely as long as this copyright message is kept intact.
	
	***********************************************************************************************/ 
   	
	var displayWaitMessage=true;	// Display a please wait message while images are loading?
  	
   		
	var activeImage = false;
	var imageGalleryLeftPos = false;
	var imageGalleryWidth = false;
	var imageGalleryObj = false;
	var maxGalleryXPos = false;
	var slideSpeed = 0;
	
	var imageGalleryCaptions = new Array();
	function startSlide1(e)
	{
		if(document.all)e = event;
		var id = this.id;
		this.getElementsByTagName('IMG')[0].src = 'images/' + this.id + '_over.gif';	
		if(this.id=='arrow_right1'){
			slideSpeedMultiply = Math.floor((e.clientX - this.offsetLeft) / 5);
			slideSpeed = -1*slideSpeedMultiply;
			slideSpeed = Math.max(-10,slideSpeed);
		}else{			
			slideSpeedMultiply = 10 - Math.floor((e.clientX - this.offsetLeft) / 5);
			slideSpeed = 1*slideSpeedMultiply;
			slideSpeed = Math.min(10,slideSpeed);
			if(slideSpeed<0)slideSpeed=10;
		}
	}
	
	function releaseSlide1()
	{
		var id = this.id;
		this.getElementsByTagName('IMG')[0].src = 'images/' + this.id + '.gif';
		slideSpeed=0;
	}
		
	function gallerySlide1()
	{
		if(slideSpeed!=0){
			var leftPos = imageGalleryObj.offsetLeft;
			leftPos = leftPos/1 + slideSpeed;
			if(leftPos>maxGalleryXPos){
				leftPos = maxGalleryXPos;
				slideSpeed = 0;
				
			}
			if(leftPos<minGalleryXPos){
				leftPos = minGalleryXPos;
				slideSpeed=0;
			}
			
			imageGalleryObj.style.left = leftPos + 'px';
		}
		setTimeout('gallerySlide()',20);
		
	}
	
	function showImage1()
	{  
		if(activeImage){
			activeImage.style.filter = 'alpha(opacity=50)';	
			activeImage.style.opacity = 0.5;
		}	
		this.style.filter = 'alpha(opacity=100)';
		this.style.opacity = 1;	
		activeImage = this;	
	}
	
	function initSlideShow1()
	{
		document.getElementById('arrow_left1').onmousemove = startSlide;
		document.getElementById('arrow_left1').onmouseout = releaseSlide;
		document.getElementById('arrow_right1').onmousemove = startSlide;
		document.getElementById('arrow_right1').onmouseout = releaseSlide;
		
		imageGalleryObj = document.getElementById('theImages1');
		imageGalleryLeftPos = imageGalleryObj.offsetLeft;
		imageGalleryWidth = document.getElementById('galleryContainer1').offsetWidth - 80;
		maxGalleryXPos = imageGalleryObj.offsetLeft; 
		minGalleryXPos = imageGalleryWidth - document.getElementById('slideEnd1').offsetLeft;
		var slideshowImages = imageGalleryObj.getElementsByTagName('IMG');
		for(var no=0;no<slideshowImages.length;no++){
			slideshowImages[no].onmouseover = showImage;
		}
		
		var divs = imageGalleryObj.getElementsByTagName('DIV');
		for(var no=0;no<divs.length;no++){
			if(divs[no].className=='imageCaption1')imageGalleryCaptions[imageGalleryCaptions.length] = divs[no].innerHTML;
		}
		gallerySlide();
	}
	
	function showPreview1(imagePath,imageIndex){
		var subImages = document.getElementById('previewPane1').getElementsByTagName('IMG');
		if(subImages.length==0){
			var img = document.createElement('IMG');
			document.getElementById('previewPane1').appendChild(img);
		}else img = subImages[0];
		
		if(displayWaitMessage){
			document.getElementById('waitMessage1').style.display='inline';
		}
		document.getElementById('largeImageCaption1').style.display='none';
		img.onload = function() { hideWaitMessageAndShowCaption(imageIndex-1); };
		img.src = imagePath;
		
	}
	function hideWaitMessageAndShowCaption1(imageIndex)
	{
		document.getElementById('waitMessage1').style.display='none';	
		document.getElementById('largeImageCaption1').innerHTML = imageGalleryCaptions[imageIndex];
		document.getElementById('largeImageCaption1').style.display='block';
		
	}
	
	window.onload = initSlideShow;