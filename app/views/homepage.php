<?php 
$this->layout('layout', ['title' => 'Blog']) ?>


<div class="container">
	<div class="row">
		<div class="col-md-12 offset-md-2">
			<a href="view/create.php" class="btn btn-success" >Add Post</a>
			<table class="table">
			  	<thead>
				    <tr>
					    <th scope="col">#</th>
					    <th scope="col">Title</th>
					    <th scope="col">Description</th>
					    <th scope="col">Actions</th>
				     </tr>
			  	</thead>
			    <tbody>
			    	<?php foreach ($posts as $post): ?>
					    <tr>
					      <th scope="row"><? echo $post['id'];?></th>
					        <td><a href="show.php?id=<? echo $post['id'];?>"><? echo $post['title'];?></a></td>
					        <td><? echo $post['description'];?></td>
					      <td>
					      	<a href="edit.php?id=<? echo $post['id'];?>" class="btn btn-warning">Edit</a>
					      	<a href="delete.php?id=<? echo $post['id'];?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')" >Delete</a>
					      </td>
					    </tr>
					<?php endforeach; ?>
			    </tbody>
		    </table>
		</div>
		<?php echo $page;?>
		<p>
		    <?php echo $page->getTotalItems(); ?> найдено.
		    
		    Показано 
		    <?php echo $page->getCurrentPageFirstItem(); ?> 
		    - 
		    <?php echo $page->getCurrentPageLastItem(); ?>.
		</p>
	</div>
</div>
