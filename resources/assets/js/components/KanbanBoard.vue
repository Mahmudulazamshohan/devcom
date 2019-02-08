
<template>
	<div style="margin-top:50px;margin-bottom:100px;position: fixed;width:100%;height:100%;z-index:999;">
		<div class="board-header">
			<h1 class="board-title">{{board_name}}</h1>
			
				<select class="ui fluid dropdown" style="width:300px;border-radius:4px;margin-top:9px;border:1px solid rgb(189, 174, 174);" @click="changeVisibility">
					<optgroup label="Change Visibility">
					  <option>Public</option>
					  <option>Private</option>	
					</optgroup>
				</select>
				<div class="search-user">
					
						<img :src="user_image.image_url" alt="" class="image-button" v-for="user_image in user_images">
					
					<div class="search-button" @click="searchBoxToggle"><i class="fa fa-user-plus"></i></div>
				</div>
			
			

		</div>
		<div class="drows" style="padding-left:10px;padding-right:10px;">
		 <div  v-for="card in cards" class="white-bg" :class="{'margin-increase':card.card_items.length == 1}">
		 	<h3 
		 	class="kanbanboard-title" 
		 	v-if="card.card_title_editable"
		 	@click="cardTitleEditable(card)"
		 	>{{card.card_title}} 
		 	<i class="fa fa-edit" style="float:right;" ></i>
		    </h3>
		    <input  
			    v-else 
			    class="title_edit_input" 
			    @keyup.enter="pressEnter(card)" 
			    v-model="card.card_title" 
			    value="card.card_title" 
			    type="text"
			    
			    >
			<!-- Kanban Board   -->  
		 	<div class="kanban-board" :class="{'kanban-board-padding':card.card_items.length == 0 && card.card_items.item_type != 'text'}">
		  	<div v-for="item in card.card_items" style="box-sizing:border-box;width:100%;">
		  		<!-- Kanban Board Image -->
		  		<div v-if="item.item_type == 'image'" class="card_image_board">
		  			<img 
		  			 :src="item.item_src" 
			  		 :alt="item"
		  		     @click="cardAdd(item)"
		  		     class="card_image"
		  		     >
		  		</div>
		  		<!-- Kanban Board Image Card -->
		  		<!-- Kanban Board Text Card -->

		  		<div v-else-if="item.item_type == 'text'" @click="cardAdd(item)"  class="card_text">
		  			<div style="flex-grow:6;position:relative;">
		  				<p style="overflow-wrap: break-word;width:100%;position:absolute;background:#fff;">{{item.item_src}}</p>
		  			</div>
		  			
		  			 <div style="flex-grow:1;">
		  			 	<i class="fa fa-eye" style="float:right;z-index:1000;color:#555;padding:4px;border:1px solid #555;
		  			 	border-radius:50%;box-shadow:0px 2px 4px rgba(0,0,0,.2);"></i> 
		  			 </div>
		  			 
		  		</div>
		  		<div v-else class="card_text" @click="cardAdd(item)">
		  			<div style="flex-grow:6;position:relative;">
		  				<p style="overflow-wrap: break-word;width:100%;position:absolute;background:#fff;">File Uploaded</p>
		  			</div>
		  			<div style="flex-grow:1;">
		  			 	<i class="fa fa-paperclip" style="float:right;z-index:1000;color:#555;padding:4px;border:1px solid #555;
		  			 	border-radius:50%;box-shadow:0px 2px 4px rgba(0,0,0,.2);"></i> 

		  			 </div>
		  		</div>

		  	</div>
		   </div>
		  <!-- Kanban Board   -->  
		  <!--  Board Bottom	 -->
		   <div class="kanbanboard-bottom">
		   	  <div class="kanbanboard-new" v-if="card.add_new_card">
		   	    <textarea 
			   	     placeholder="Enter a title for this card"
			   	     v-model="api_tools.card_title_input"
			   	     id="card_title_input"
			   	     :class="{'min': card.card_items.length <=5 }"

		   	     ></textarea>
		   	    <div class="kanbanboard-new-button">
		   	      <button class="ui button primary small" @click="addCardItem(card)">Add</button> 
		   	      
		   	       <div style="display:flex;flex-direction:row;">
		   	       	 	<input type="file" id="attachment-file" style="display:block;" class="custom-file-input" @change="attachmentUpload(card)">
		   	       	    <button class="mini ui inverted button grey" style="width:24%;height:31px;" @click="closeCurrentCard(card)">
		   	       	    	<i class="fa fa-remove grey-text"></i>
		   	       	    </button>
		   	       </div>
		 
		   	    </div>
		     </div>
		     <div class="kanbanboard-bottom-button">
		   	   <i class="fa fa-plus" @click="addAnotherCard(card)">Add Card</i>  
		     </div>
		   </div>
		   <!--  Board Bottom	 -->
		 </div>	
		 <div  class="mr-10">
		 	<div style="display:flex;flex-direction:column;background:#fff; border-radius:5px !important;padding:10px;max-width:182px;min-width:182px;">
		 		<div class="ui form mr-10">
				 	<div class="field">
				 	  <input type="text" v-model="api_tools.add_new_card_title" >
				 	</div>
			    </div>
			 	<button class="ui button olive inverted mr-10" @click="add">
			 		<i class="fa fa-plus"></i> Add another list
			 	</button>
		 	</div>
		 	
		 </div>
		</div>
		<!-- Modal -->
       <div id="myModal" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  	<div class="close-container"> 
		  		<span class="close-left">
		  			<i class="fa fa-window-maximize"></i><p style="font-size:18px;margin-left:10px;">Card</p>
		  		</span>
		  		<span class="close">&times;</span>
		  	</div>

	        <div class="image-container" v-if="modal.modal_type == 'image' "  id="image-container">
	        	<img :src="modal.modal_src" alt="" @click="openTab(modal.modal_src)" id="images">
	        	
	        </div>
	        <div v-else-if="modal.modal_type == 'text'">
	        	<h3 style="padding-left:25px;padding-bottom:10px;"><i class="fa fa-file-text"></i>&ensp;{{modal.modal_src}}</h3>
	        </div>
	        <div v-else-if="modal.modal_type == 'file'">
	        	
	        	<a :href="modal.modal_src" class="ui button primary small" style="margin-left:25px;margin-top:10px;margin-bottom:10px;">
	        		<i class="fa fa-paperclip" ></i>&ensp;Attachment
	        	</a>
	        </div>
	        <div class="main-container">
	        	<!-- Main Container Modal -->
	         <div class="description">
	         	<h4>
	         		<i class="fa fa-align-left"></i>&ensp;Description
	         		<div style="float:right;">
	         			<img :src="modal.image_url" alt="" style="width:30px;height:30px;border-radius:50%;margin:0 auto 0 auto;">
	         			<p style="font-size:12px;">{{ modal.user_name }}</p>
	         		</div>
	         	</h4>
	         	<div class="description-text">
	         		<!-- Description of modal -->
	         		<div class="display:flex;flex-direction:row;">
	         			<textarea 
		         		style="width:60%;border-radius:4px;max-width:80%;height:100px;border:0px solid #8785A5;padding:10px;resize:none;min-width:80%;font-weight:600;" v-model="api_tools.description_text_values" 
		         		@keyup.enter="saveDescription(modal)"
		         		placeholder="Please write card description" 
		         		class="textarea-description" 
		         		></textarea>
		         		<div class="btn-area">
			         	     <button class="ui button green" @click="saveDescription(modal)">
			         	        Save
			         	     </button>  	      		  
			         	</div>
	         		</div>

	         		<!-- Description of modal -->
	         		
	         	</div>
	         	

	         	
	         </div>	
	         <!-- Comment Section -->
	         <div class="comment-section">
	         	<h3><i class="fa fa fa-comment-o"></i>&ensp;&ensp;Add Comment</h3>
	         	<div class="comment-input">
	         		<textarea style="width:60%;height:100px;border-radius:4px;box-shadow:0px 2px 2px rgba(0,0,0,0.2);" v-model="api_tools.comment_texts"></textarea>
	         		<div style="margin-top:10px;">
	         			<button class="ui button green" @click="saveComments(modal)">Save</button>
	         		</div>
	         		
	         	</div>
	         	<div class="activity-section">
	         	   <h3><i class="fa fa-server"></i>&ensp;&ensp;Activity</h3>
	            </div>
	         	<!-- Comment  -->
	         	<div class="comment-data">
	         		<div class="comment-data-box" v-for="comment in modal.comments">
	         			<div class="image-box">
	         			  <img :src="comment.image_url" alt="" style="width:40px; height:40px; border-radius:50%;">
	         			  <div style="display:flex;flex-direction:column;padding:4px;">
	         			  	<p>{{comment.user_name}}</p>
	         			  	 <div class="text-card">
	         		    	  {{comment.comment_text}}
	         		         </div>
	         			  </div>
	         			</div>
	         		   
	         		</div>
	         	</div>
	         	<!-- Comment  -->
	         </div>
	         <!-- Comment Section -->

	         
	          <!-- Main Container Modal -->
	        </div>
		  </div>

		</div>
		<!-- Modal -->
		 <!-- Modal -->
       <div id="search-modal" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  	<div class="close-container"> 
		  		<span class="close">&times;</span>
		  	</div>

	       
	        <div class="main-search-box">
	        	<div class="search-friends">
	        		<input type="text" class="ui form" v-on:input="searchItems" v-model="api_tools.search_user_text">
	        		<button class="ui button green"><i class="fa fa-search"></i></button>
	        	</div>
	        	<div class="search-results">
	        		<div class="result-box" v-for="search_item in search_items">
	        			<img :src="search_item.image_url" alt="" style="width:40px;height:40px;border-radius:50%;flex-glow:1;padding:2px;">
	        			<p class="user-name" style="flex-glow:4;font-weight:bold;padding:2px;flex-glow:3;width:60%;">
	        				{{ search_item.user_name }}
	        			</p>
	        			<div class="add-user-now" style="flex-glow:2;padding:2px;">
	        				<button class="ui button primary circular" @click="addThisBoard(search_item)" :class="{'green-bg':search_item.change_icon}">
	        					<i class="fa fa-user-plus" v-if="!search_item.change_icon"></i>
	        					<i class="fa fa-check" v-else></i>
	        				</button>
	        			</div>
	        		</div>
	        	</div>
	        		
	        </div>

		  </div>

		</div>
		<!-- Modal -->
	</div>
</template>
<script type="text/javascript">

export default{
	    created(){
				axios.get('../../../board-all/'+this.title).then((res)=>{
					   res.data.forEach((r)=>{
					   	this.cards.push(r); 
					   });
					   this.api_tools.add_new_card_title = "";
				   });
				axios.get('../../../board-users?board_id='+this.title).then((res)=>{
					   //console.log(res);
					   this.user_images = res.data;
				   });
	    },
		data(){
			return {
			  cards:[],
			  modal:{
			 	modal_title:'',
			 	modal_type:'',
			 	modal_labels:[],
			 	modal_description:'',
			 	modal_src:'',
			 	board_list_id:'',
			 	id:'',
			 	board_unique_id:'',
			 	image_url:'http://127.0.0.1/devcom/public/images/user-blank.png',
			 	user_name:'',
			 	comments:[]
			 },
			 api_tools:{
			 	card_title_input:'',
			 	add_new_card_title:'',
			 	description_text_values:'',
			 	search_user_text:"",
			 	comment_texts:"",
			 },
			 extra_ui:{
			 	card_loader:false,
			 	is_show_description:false
			 },
			 search_items:[],
			 user_images:[]

			
		 }
		},
		methods:{

			add(){
				
				if(this.api_tools.add_new_card_title.length  != 0){
					axios.get('../../../board/'+this.title+'/'+this.api_tools.add_new_card_title).then((res)=>{
						this.cards.push(res.data.cards); 
						this.api_tools.add_new_card_title ="";
				   });
				}else{
					alert('Please enter card title');
				}
				
				
		  },
		  pressEnter(card){
		  	card.card_title_editable = true;

		  	axios.get('../../../edit-title',{
				    params: {
				      board_list_id:card.board_list_id,
				      card_title:card.card_title
				    }
				  }).then((res)=>{
		  	        //console.log(res.data);
		  	       
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });
		  },
		  cardTitleEditable(card){
		  	card.card_title_editable = false;
		  },
		  cardAdd(item){
		  	 //Set Modal Items
		  	 this.extra_ui.is_show_description = false;
		  	 this.modal.modal_src = item.item_src;
		  	 this.modal.modal_type = item.item_type;
		  	 this.modal.board_list_id = item.board_list_id;
		  	 this.api_tools.description_text_values = item.item_description;
		  	 this.modal.id = item.id;
		  	 this.modal.image_url = item.image_url;
		  	 this.modal.user_name = item.user_name;
		  	 this.modal.board_unique_id = item.board_unique_id;

		  	 axios.get('../../../card-comments',{
				    params: {
				      board_list_id:this.modal.board_unique_id,
				    }
				  }).then((res)=>{
		  	        this.modal.comments = res.data;
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });
		  	    //console.log(item);
		  	    var closeModal = $('.close');
		  	    closeModal.click(function(){
		  	    	$('#myModal').css({display: 'none'});
		  	    	
		  	    });	
			  	$('#myModal').css({display: 'block'});
			  	window.onclick = function(event) {
				  if ($('#myModal').is(event.target)) {
				    $('#myModal').css({display: 'none'});
				  	
				  }
				}
			
				
		  },
		  addAnotherCard(card){
		  	this.api_tools.card_title_input = "";
		  	card.add_new_card = true;
		  },
		  addCardItem(card){

		  	   if(this.api_tools.card_title_input.length > 0){
		  	   	    if(this.api_tools.card_title_input.length <=23){
		  	   	       card.add_new_card = false;
		  	   	       var formData = new FormData();
		  	   	       formData.append('board_id',this.title);
				  	   formData.append('board_list_id',card.board_list_id);
				  	   formData.append('card_title',this.api_tools.card_title_input);
		  	   	       axios.post('../../../board-data-text',formData).then((res)=>{
						   card.card_items.push(res.data);
					   });

				  	   this.api_tools.card_title_input = "";
				  			
		  	   	    }else{
		  	         	alert('Card title must be 23 character');

		  	   	    }

		  	   	    
		  	   }else{
		  	   	alert('Please enter card title');
		  	   }
		  	    

		  },
		  closeCurrentCard(card){
		   	card.add_new_card = false;

		  },
		  attachmentUpload(cardList){
		  	
		
		  	this.extra_ui.card_loader = true;

		  	var file = $('#attachment-file').click();
		  	var size = file.length,
		  	    file = file[0].files[0];
		  	
		        //Form Data
		  		var formData = new FormData();
				  	formData.append('video',file);
				  	formData.append('board_id',this.title);
				  	formData.append('board_list_id',cardList.board_list_id);
				  	//Post Request To API
				  	 axios.post('../../../board',formData,{
				  		headers: {
				          'Content-Type': 'multipart/form-data'
				        },
				        onUploadProgress:function(uploadEvent){
				        	var loadingPercentage = Math.floor(uploadEvent.loaded / uploadEvent.total)*100;
				        	//console.log(loadingPercentage);
				        		
				        },
				        responseType: 'json',
				      }).then((res)=>{
		   	                cardList.add_new_card = false;
				      	    this.extra_ui.card_loader = false;
				      	    cardList.card_items.push(res.data.card_items);
				      	}).catch((err)=>{
					  	  	if(err){
					  	  		this.extra_ui.card_loader = false;
					  	  	}
				  	  });
		  	
		  	

		  },
		  openTab(modalTitle){
		  	var win = window.open(modalTitle,'_blank');
		  	win.focus();

		  },
		  addDescription(){
		  	this.extra_ui.is_show_description = true;
		  },
		  saveDescription(modal){
		  	modal.modal_description = this.api_tools.description_text_values;
		    //Save Description
		  	axios.get('../../../save-board-list-description',{
				    params: {
				      id: modal.id,
				      description:this.api_tools.description_text_values
				    }
				  }).then((res)=>{
		  	     	console.log(res);
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });
		  	//this.api_tools.description_text_values = "";
		  	this.extra_ui.is_show_description = false;     
		  },
		  changeVisibility(){
		  	alert('Hello');
		  },
		  searchBoxToggle(){
		  	var closeModal = $('.close');
		  	    closeModal.click(function(){ 
		  	    	        $('#search-modal').css({display: 'none'}); 
		  	              });	
			  	$('#search-modal').css({display: 'block'});
			  	window.onclick = function(event) {
				  if ($('#search-modal').is(event.target)) {
				    $('#search-modal').css({display: 'none'});
				  	
				  }
			    };
		  },
		  searchItems(event){
            //Search users
            axios.get('../../../search-users',{
				    params: {
				      q:this.api_tools.search_user_text,
				      board_id:this.title
				    }
				  }).then((res)=>{
		  	     	this.search_items = res.data;
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });

		  },
		  addThisBoard(search_item){
		  	if(search_item.change_icon){
		  	 search_item.change_icon = false;
		  	 console.log(this.title);
		  	 axios.get('../../../delete-board-members',{
				    params: {
				      board_id:this.title,
				      user_id:search_item.id
				    }
				  }).then((res)=>{
		  	     	//console.log(res);
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });
		  	// alert(search_item.user_name);	
		  	}else{
		  	 search_item.change_icon = true;

		  	 axios.get('../../../add-board-members',{
				    params: {
				      board_id:this.title,
				      user_id:search_item.id
				    }
				  }).then((res)=>{
		  	     	//console.log(res);
		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });

		  	// alert(search_item.user_name);	
		  	}
		  	
		  },
		  saveComments(modal){
		  	 axios.get('../../../add-card-comments',{
				    params: {
				      board_list_id:modal.board_unique_id,
				      comment_text:this.api_tools.comment_texts
				    }
				  }).then((res)=>{
		  	     	 modal.comments.unshift(res.data);
		  	     	 this.api_tools.comment_texts="";

		  	     }).catch((err)=>{
		  	     	if(err){
		  	     		console.log(err);
		  	     	}
		  	     });
		  }
		  
		},
		props:['title','value','board_name'],
		
	};
</script>

<style type="text/css">
   .search-user{
		margin-top:9px;
		display: flex;
		flex-direction: row;
		float: right;
		margin-left: 60px;

	}
	.search-user .search-user-input{
		border-radius: 4px 0px 0px 4px; 
		border:1px solid #eeeeee;
		padding: 4px;
	}
	.search-user .image-button{
		width:40px;
		height:40px;
		border-radius:50%;
		border:1px solid #d8ea5c;
		box-shadow:0px 0px 2px rgba(0,0,0,0.3);
		margin-right: 4px;
	}
	.search-user .search-button{
		background:#D8EA5C;
		border-radius: 50%;
		padding: 13px;
		color:#fff;
		box-shadow: 0px 1px 1px rgba(0,0,0,.2);
	}
	.search-user .search-button:hover{
		background:#FFDF05
	}
	.search-button i{
		text-align: center;
		color: #555;
		text-shadow: 0px 1px 1px rgba(0,0,0,.2);
	}
   .activity-section{
   	border-bottom:1px solid #ccc;
   	padding-bottom:10px;
   	margin-bottom:5px;
   }
   .main-search-box{
   	padding: 30px;
   }
   .comment-data{
   	
   }
   .comment-data-box{
   	display: flex;
   	flex-direction: column;
   	border-bottom: 1px solid #ccc;
   	padding-bottom:10px;
   }
   .text-card{
   	background:#fff;
   	box-shadow: 0px 1px 5px rgba(0,0,0,0.2);
   	padding: 10px;
   	font-weight: bold;
   	border:1px solid #eee;
   	border-radius: 4px;
   	max-width:100% !important;
   }
   .comment-data-box .image-box{
   	 display: flex;
   	 flex-direction: row;
   }
   .green-bg{
   	background:#16AB39 !important;
   }
   .result-box{
   	display: flex;
   	flex-direction: row;
   	margin:0 auto 0 auto;
   	width: 63%;
   	background: #eee;
   	border-radius: 4px;
   	padding: 4px;
   	margin-top: 4px;
   }
   .main-search-box .search-friends{
   	width: 100%;
   	display: flex;
   	flex-direction: row;

   }
   .main-search-box .search-friends input{

   	 border-radius: 4px 0px 0px 4px;
   	 padding: 10px;
   	 border:1px solid #16AB39;
   	 flex-grow:8;
   }
   .main-search-box .search-friends .button{
   	 flex-grow:1;
   	 border-radius: 0px 4px 4px 0px;
   }
   .comment-section{
   	margin-top: 20px;
   }
   .comment-section .comment-input{
   	display: flex;
   	flex-flow: column;
   	padding:10px;
   }
	.close-container{
	border-bottom: 2px solid #ccc;
	}
	.card_image_board{

	}
	.small{
	padding: 10px;
	}
	.kanbanboard-new{
	display: flex;
	flex-direction:column;
	padding: 5px;

	}
	.kanbanboard-new-button{
	display: flex;
	flex-direction:row;
	}

	.kanbanboard-new textarea{
	width:100%;
	border-radius: 4px;
	box-shadow: 0px 2px 3px rgba(0,0,0,0.2);
	resize: none;
	min-height: 100px;
	padding: 5px;


	}
	.min{
	min-height: 30px !important;
	}
	.kanbanboard-new .button{
	width: 30%;
	margin-top: 10px;
	margin-left: 10px;


	}
	.kanbanboard-bottom{
	border-radius: 0px 0px 4px 4px;
	background: #fff;
	padding:7px;
	position: absolute;
	width: 100.4%;
	bottom: -27px;
	left: 0.1%;
	box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
	border-top: 2px solid rgba(0,0,0,0.3);
	border-left: 2px solid #eee;
	border-right: 2px solid #eee;
	border-bottom: 2px solid #eee;
	}
	.title_edit_input{
	width:100%;
	border-radius:4px 4px 0px 0px;
	padding:10px 10px;
	border:0;
	}
	.card_image{
	width:100%;
	height:auto;
	position:relative;
	margin: 4px;
	border-radius: 4px;
	border:1px solid #fafafa;
	box-shadow: 0 1px 0 rgba(9,45,66,.25);

	}
	.card_text{

	display: flex;
	flex-flow: row;

	width: 100%;
	height: auto;
	margin: 2px 0px 2px 0px;
	box-shadow: 0 1px 0 rgba(9,45,66,.25);
	background: #fff;
	border-radius: 4px;
	padding:10px;
	}
	.kanbanboard-title{
	color:#000;
	background:#fff;
	margin-bottom:0;
	border-radius: 4px 4px 0px 0px;
	padding: 10px;
	width: 100%;


	}
	.drows{
	display:flex;
	flex-flow:row;
	overflow-x: scroll !important;
	overflow-y: scroll !important;

	}
	body{

	background-image: url('https://images.unsplash.com/photo-1547838555-204e1f648a15?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1366&q=80');
	background-repeat: none;
	background-size: cover;
	background-position: 100%;
	}
	.white-bg{
	margin:4px;
	background: #DFE3E6;
	min-width: 282px !important;
	max-width: 282px !important;
	position: relative;
	min-height:100px; 
	border-radius: 4px;
	height: 100%;
	margin-bottom:50px;
	border:1px solid #eee;
	box-sizing:border-box;
	}
	.margin-increase{
	margin-bottom: 50px;
	}
	.kanban-board{
	display:flex;
	flex-direction:column;
	padding:10px;
	border-radius:4px;
	background:#DFE3E6;
	max-height:357px; 
	overflow:auto;
	box-sizing: border-box;
	position: relative;


	}
	.kanban-board-padding{
	padding: 120px 10px;
	}
	.kanban-board:last-child{
	margin-bottom:100px;
	}


	.modal {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	z-index: 1; /* Sit on top */
	padding-top: 10px; /* Location of the box */
	left: 0;
	top: 0;
	width: 100%; /* Full width */
	height: 100%; /* Full height */
	overflow: auto; /* Enable scroll if needed */
	background-color: rgb(0,0,0); /* Fallback color */
	background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	background-color: #fefefe;
	margin: auto;
	display: flex;
	flex-direction: column;
	border: 1px solid #888;
	width: 55%;
	border-radius: 4px;
	}

	/* The Close Button */
	.close {
	color: #aaaaaa;
	float: right;
	font-size: 28px;
	font-weight: bold;
	background:#555;
	border-radius: 50%;
	width: 30px;
	height: 30px;
	text-align: center;
	margin:5px;
	box-shadow: 0px 2px 3px rgba(0,0,0,0.2);
	border:1px solid #ccc;
	}
	.close-left{
	float:left;
	width: 30px;
	height: 30px;
	margin-top:10px;
	margin-left:10px;
	display: flex;
	flex-direction: row;
	}

	.close-left i{
	font-size:22px;
	color:#555;
	}
	.close:hover,
	.close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
	}

	/*Styling File Input*/
	.custom-file-input {
	color: transparent;
	}
	.custom-file-input::-webkit-file-upload-button {
	visibility: hidden;
	}
	.custom-file-input::before {
	content: 'Upload files';
	color: black;
	display: inline-block;
	background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	border: 1px solid #999;
	border-radius: 3px;
	padding: 5px 8px;
	outline: none;
	white-space: nowrap;
	-webkit-user-select: none;
	cursor: pointer;
	text-shadow: 1px 1px #fff;
	font-weight: 700;
	font-size: 10pt;
	}
	.custom-file-input:hover::before {
	border-color: black;
	}
	.custom-file-input:active {
	outline: 0;
	}
	.custom-file-input:active::before {
	background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
	}


	.board-header{
	width:100%;
	height:50px;
	background: rgba(255,255,255,0.45);
	display: flex;
	flex-direction: row;
	margin-bottom:10px;


	}
	.mr-10{
	margin-top:10px !important;
	}
	.board-header .board-title{
	color: #555;
	padding:5px;

	margin-left:20px;
	border-radius: 5px;


	}
	.board-header .board-title:hover{
	background:rgba(255,255,255,0.7);
	}
	.image-container{
	background-color: #DFE3E6;

	height:250px;
	background-size: contain;
	background-origin: content-box;
	padding: 0px;
	box-sizing: border-box;
	background-position: center center;
	position: relative;

	}
	.image-container img{
	position: absolute;
	width:100%;
	height:100%;
	object-position: 50% 0%;
	display:hidden;
	object-fit:contain;

	}
	#image-container #button{
	position: absolute;
	padding: 0 1em;
	display: none;
	}

	#images:hover + #button{
	display: block;
	background:#000;
	}
	input#attachment-file {
	margin-top: 11px;
	width: 100%;
	}
	.grey-text{
	color:#000;
	}
	.main-container{
	padding: 10px 25px 10px 25px;
	}
	.main-container .description{
	display: flex;
	flex-direction: column;
	border-bottom: 0.08em dashed #555;
	padding-bottom: 10px;
	box-shadow: 0px 1px 1px rgba(0,0,0,0.02);

	}
	.textarea-description:focus{
	 border:1px solid #555;
	}
</style>