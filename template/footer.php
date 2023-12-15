				</div><!------------------ right ------------------>
			<div class="cl">&#160;</div>
		<div class="clear"></div>
	</div> <!-------------------------- main ------------------>
	<div id="footer">
	
		<?php FooterMenu::getFooterMenu("menu.xml"); ?>
		<div class="paypallogo"><img src="images/paypal-verified-footer-logo.png" alt="Logo PayPal"></div>
		<div class="clear"></div>
		<p id="footerCopyRights">&copy; <script type="text/javascript">document.write(new Date().getFullYear());</script> <?php echo $business->name; ?></p>
		
	</div>
			<div id="overlay"><div id="insideOverlay"></div></div>
		<div class="clear"></div>
		<div id="goTop" title="Go Top" onclick="activeGoTop();"></div>
</div> <!---------------------------  page ------------------------------->
</body>
<script src="js/basket.js" type="text/javascript"></script>
<script type="text/javascript">
	window.onresize = function(){
		layoutHeader();
			if(getElementId("homeSlideShow") != null){homeSlideShowSize();}
				if(getElementId("reviewblock")!= null){reviewBlock(GlobalGetHeightReviewBlock);}
					leftmenublock(GlobalHeightLeftMenu);
						sizeInPopupInfo();
							placeNewItemsBlock(GlobalVarNewItemsBlock);
								putSizeInProduct();
									putZoom();
										positionGoTop();
											 addPlaseHolder();
												sameHeight();
								   
	}
</script>
</html>	
	