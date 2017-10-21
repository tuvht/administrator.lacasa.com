<div class="categorieslistview">
	<h3>Category</h3>
	<ul class="lists">
		<li class="listparent">
			<label>Women</label>
			<ul class="listsub">
				<li>
					<label>Top</label>
					<ul class="listsub">
						<li><a href="#">Shirt</a></li>
						<li><a href="#">T-Shirt</a></li>
						<li><a href="#">Sweater</a></li>
						<li><a href="#">View all</a></li>
					</ul>
				</li>
				<li>
					<label>Bottom</label>
					<ul class="listsub">
						<li><a href="#">Shirt</a></li>
						<li><a href="#">T-Shirt</a></li>
						<li><a href="#">Sweater</a></li>
						<li><a href="#">View all</a></li>
					</ul>
				</li>
				<li>
					<label>Shoes</label>
					<ul class="listsub">
						<li><a href="#">Shirt</a></li>
						<li><a href="#">T-Shirt</a></li>
						<li><a href="#">Sweater</a></li>
						<li><a href="#">View all</a></li>
					</ul>
				</li>
				<li>
					<label>Accessories</label>
					<ul class="listsub">
						<li><a href="#">Shirt</a></li>
						<li><a href="#">T-Shirt</a></li>
						<li><a href="#">Sweater</a></li>
						<li><a href="#">View all</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="listparent">
			<label>men</label>
			<ul class="listsub">
				<li>
					<label>Top</label>
					<ul class="listsub">
						<li><a href="#">Shirt</a></li>
						<li><a href="#">T-Shirt</a></li>
						<li><a href="#">Sweater</a></li>
						<li><a href="#">View all</a></li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
</div>
<script type="text/javascript">
	$( document ).ready(function() {
		$('.lists').each(function(){
			$(this).find('label').each(function(){
				
				$(this).next('ul').each(function(){
					$(this).addClass('collapse');
				});

				$(this).click(function(){
					$(this).toggleClass('active');
					$(this).next('.collapse').toggleClass('in');
				});
			});
		});
	});
</script>