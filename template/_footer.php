			</div>
		<div class="cl">&#160;</div>
		<div class="clear"></div>
	</div> <!-- main -->
<div id="footer">
	<div id="footer_in">
		&copy; <a href="">GGGG</a>
	</div>
</div>
		<script src="js/basket.js" type="text/javascript"></script>
	<div id="overlay"><div id="insideOverlay"></div></div>
<div class="clear"></div>
</div> <!-- class page -->
</body>
<script type="text/javascript">
	window.onresize = function(){
		layoutHeader();
			if(getElementId("homeSlideShow") != null){homeSlideShowSize();}
				if(getElementId("reviewblock")!= null){reviewBlock(GlobalGetHeightReviewBlock);}
					leftmenublock(GlobalHeightLeftMenu);
						sizeInPopupInfo();
							placeNewItemsBlock(GlobalVarNewItemsBlock);
	}
</script>
</html>	
	