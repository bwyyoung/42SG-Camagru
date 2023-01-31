function likePost(i) {
	  var request = new XMLHttpRequest();
	  var url = "functions/like.php";
	  request.open("POST", url, true);
	  request.setRequestHeader("Content-Type", "application/json");
	  request.onreadystatechange = function () {
		  if (request.readyState === 4 && request.status === 200) {
			  //var jsonData = JSON.parse(request.response);
			  //console.log(jsonData);
			var num_likes = document.getElementById('num_likes');
			num_likes.innerHTML = request.response;
		  }
	  };
	  var img_id =  document.getElementById("image_id").value;
	  var login = document.getElementById("loggued_on_user").value;

	  var data = JSON.stringify({"img_id": img_id, "login": login});

	  request.send(data);

	  if(i == 1) {
		document.getElementById("like-btn-1").style.display = "none";
		document.getElementById("like-btn-0").style.display = "block";
	  } else {
		document.getElementById("like-btn-1").style.display = "block";
		document.getElementById("like-btn-0").style.display = "none";
	  }
  }

  function commentPost(event) {
	event.preventDefault();
	var img_id =  document.getElementById("image_id").value;
	var login = document.getElementById("loggued_on_user").value;
	var comment = document.getElementById("comment_input").value;
	comment = comment.replace(/\r?\n/g, '<br />');
	if (img_id && login && comment) {
		var request = new XMLHttpRequest();
		var url = "functions/comment.php";
		request.open("POST", url, true);
		request.setRequestHeader("Content-Type", "application/json");
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				//var jsonData = JSON.parse(request.response);
				//console.log(jsonData);
				var num_likes = document.getElementById('num_comments');
				num_likes.innerHTML = request.response;
				var comment_box = document.getElementById('comment_list');
				var comment_list = document.createElement('p');
				comment_list.setAttribute('class', 'indiv_comment');
				comment_list.innerHTML = `<span class='comment_user_id'>${login}</span> : ${comment}`;
				comment_box.appendChild(comment_list);
			}
		};

		var data = JSON.stringify({"img_id": img_id, "login": login, "comment": comment});
		request.send(data);
	}
	document.getElementById("comment_input").value = '';
}

function showComments() {
	var comment = document.getElementById('comment_display');
	if (comment.style.display == 'block') {
		comment.style.display = 'none';
		var comment_box = document.getElementById('comment_list');
		comment_box.innerHTML = '';
	} else {
		comment.style.display = 'block';
		var request = new XMLHttpRequest();
		var url = "functions/comment_load.php";
		request.open("POST", url, true);
		request.setRequestHeader("Content-Type", "application/json");
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				if (request.response) {
					var jsonData = JSON.parse(request.response);
					var comment_box = document.getElementById('comment_list');
					for (var i = 0; i < jsonData.length; i++) {
						var obj = jsonData[i];
						var login = obj['login'];
						var read_comment = obj['comment'];
						var comment_list = document.createElement('p');
						comment_list.setAttribute('class', 'indiv_comment');
						comment_list.innerHTML = `<span class='comment_user_id'>${login}</span> : ${read_comment}`;
						comment_box.appendChild(comment_list);
					}
				}
			}
		};
		var img_id =  document.getElementById("image_id").value;

		var data = JSON.stringify({"img_id": img_id});

		request.send(data);
	}
}

function loadPosts() {
	var request = new XMLHttpRequest();
	var url = "functions/post_load.php";
	request.open("POST", url, true);
	request.setRequestHeader("Content-Type", "application/json");
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			if (request.response) {
				var jsonData = JSON.parse(request.response);
				var gallery_list = document.getElementById('gallery');

				for (var i = 0; i < jsonData.length; i++) {
					var single_post = jsonData[i];
					var count_likes = single_post['count_likes'];
					var count_comments = single_post['count_comments'];
					var img_id = single_post['id'];
					var img_src = single_post['img'];
					var login = single_post['login'];
					var gallery_item = document.createElement('div');
					gallery_item.setAttribute('class', 'gallery-item');
					gallery_item.innerHTML = `
					<img class="gallery-image" alt="" src="upload/${img_src}">
					<a href="postdetail.php?id=${img_id}" class="clean_link">
					<div class="gallery-item-info">
						<ul>
							<li class="gallery-item-likes"><span class="visually-hidden">Likes:</span>
							<i class="fas fa-heart" aria-hidden="true"></i>
							${count_likes}
							</li>
							<li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i>
							${count_comments}
							</li>
						</ul>
					`;
					gallery_list.appendChild(gallery_item);
				}
				num_load++;
				prevent_dup = 0;
			}
		}
	}
	var data = JSON.stringify({'num_load':num_load, 'num_post':num_post});
	request.send(data);
}