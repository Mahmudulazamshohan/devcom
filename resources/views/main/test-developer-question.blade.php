@extends('layouts.main-2')
@section('content')
<style type="text/css">
#quiz {
  margin: -44px 50px 0px;
  position: relative;
  width: calc(100% - 100px);
  padding: 10px;
  height: 500px;
}
.footer{
  margin-top: 100px !important;
}

#quiz h1 {
  color: #FAFAFA;
  font-weight: 600;
  font-size: 36px;
  text-transform: uppercase;
  text-align: left;
  line-height: 44px;
}

#quiz button {
  float: left;
  margin: 8px 0px 0px 8px;
  padding: 4px 8px;
  background: #9ACFCC;
  color: #00403C;
  font-size: 14px;
  cursor: pointer;
  outline: none;
}

#quiz button:hover {
  background: #36a39c;
  color: #FFF;

}

#quiz button:disabled {
  opacity: 0.5;
  background: #9ACFCC;
  color: #00403C;
  cursor: default;
}

#question {
  padding: 20px;
  background: #eee;
  text-align: center;
}

#question h2 {
  margin-bottom: 16px;
  font-weight: 600;
  font-size: 20px;
}

#question input[type=radio] {
  display: none;
}

#question label {
  display: inline-block;
  margin: 4px;
  padding: 12px;
  background: linear-gradient(to bottom, #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%);
  color: #4C3000;
  width: calc(50% - 8px);
  min-width: 50px;
  cursor: pointer;
  box-shadow: 0px 1px 3px rgba(0,0,0,0.2);
  border-radius: 5px;
}

#question label:hover {
  background: linear-gradient(to bottom, #ffffff 0%,#f3f3f3 50%,#ededed 68%,#ffffff 100%);
}

#question input[type=radio]:checked + label {
  background: linear-gradient(to bottom, #ffffff 0%,#f3f3f3 50%,#ededed 68%,#ffffff 100%);
  border:3px solid #5BBC2E;
  border-radius: 2px;
  color: #000;
}

#quiz-results {
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: absolute;
  top: 44px;
  left: 0px;
  background: #FAFAFA;
  width: 100%;
  height: calc(100% - 44px);
  padding: 10px;
  border-radius: 4px;
  margin:0 auto 0 auto;
}

#quiz-results-message {
  display: block;
  color: #00403C;
  font-size: 20px;
  font-weight: bold;
}

#quiz-results-score {
  display: block;
  color: #31706c;
  font-size: 20px;
}

#quiz-results-score b {
  color: #00403C;
  font-weight: 600;
  font-size: 20px;
}

#quiz-retry-button {

  float: left;
  margin: 8px 0px 0px 8px;
  padding: 4px 8px;
  background: #5BBC2E !important;
  color: #00403C;
  font-size: 14px;
  cursor: pointer;
  outline: none;
  border-radius: 10px;
  border:none;
  
}
#quiz_time{
  margin: 0 auto 0 auto;
}
#result{
  background: #fff;
  padding:10px;
  box-shadow:0px 1px 2px rgba(0,0,0,0.2);
}
</style>
 {{--  Content Started --}}
   <div class="card-layout-1" style="background: #eee;border:none;margin:0 auto 0 auto;" id="quiz-show">
   	 <div id="quiz">
   	 <div id="quiz_time" data-timer="60"></div>
	  <h2 id="quiz-name" style="color: #000;"></h2>
	  <button id="submit-button" style="background: linear-gradient(45deg, #49c0f0 0%,#2cafe3 100%); border-radius: 4px;padding: 10px;border:none;color:#fff;">Submit Answers</button>
	  <button id="next-question-button" style=" background: linear-gradient(45deg, #49c0f0 0%,#2cafe3 100%); border-radius: 4px;padding: 10px;border:none;color:#fff;">Next Question</button>
	  <button id="prev-question-button" style="background: linear-gradient(45deg, #49c0f0 0%,#2cafe3 100%); border-radius: 4px;padding: 10px;border:none;color:#fff;">Previous</button>
	  
	  <div id="quiz-results">
      <p id="quiz-results-message"></p>
	    <p id="quiz-results-score"></p>
	    <a id="quiz-retry-button" href="{{route('test-question-category')}}">Try Another test</a>
    </div>
  </div>
  

   </div>
    <div id="quiz-end">
      <div id="result">
         Quiz Time Out Your score now 
      </div>
    </div>
@endsection
@section('script')

<script>
   var finalscore = 0;
// Array of all the questions and choices to populate the questions. This might be saved in some JSON file or a database and we would have to read the data in.
// var all_questions = [{
//   question_string: "What color is the sky?",
//   choices: {
//     correct: "Blue",
//     wrong: ["Pink", "Orange", "Green"]
//   }
// }, {
//   question_string: "Which of the following elements aren’t introduced in HTML5?",
//   choices: {
//     correct: "<input>",
//     wrong: ["<article>", "<footer>", "<hgroup>"]
//   }
// }, {
//   question_string: "How many wheels are there on a tricycle?",
//   choices: {
//     correct: "Three",
//     wrong: ["One", "Two", "Four"]
//   }
// }, {
//   question_string: 'Who is the main character of Harry Potter?',
//   choices: {
//     correct: "Harry Potter",
//     wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
//   },
  
// },{
//   question_string: 'Who is the main character of Harry Potter?1',
//   choices: {
//     correct: "Harry Potter",
//     wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
//   },
  
// }];

// var all_questions  = [{
//   question_string: 'Who is the main character of Harry Potter?1',
//   choices: {
//     correct: "Harry Potter",
//     wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
//   }
  
// }];
var all_questions =[];


    




 all_questions.push({
              question_string: 'Who is the main character of Harry Potter?2',
              choices: {
                correct: "Harry Potter",
                wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
              }
            });
 all_questions.push({
              question_string: 'Who is the main character of Harry Potter?2',
              choices: {
                correct: "Harry Potter",
                wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
              }
            });
  
 console.log(all_questions.length);  
  




// An object for a Quiz, which will contain Question objects.
var Quiz = function(quiz_name) {
  // Private fields for an instance of a Quiz object.
  this.quiz_name = quiz_name;
  
  // This one will contain an array of Question objects in the order that the questions will be presented.
  this.questions = [];
}

// A function that you can enact on an instance of a quiz object. This function is called add_question() and takes in a Question object which it will add to the questions field.
Quiz.prototype.add_question = function(question) {
  // Randomly choose where to add question
  var index_to_add_question = Math.floor(Math.random() * this.questions.length);
  this.questions.splice(index_to_add_question, 0, question);
}

// A function that you can enact on an instance of a quiz object. This function is called render() and takes in a variable called the container, which is the <div> that I will render the quiz in.
Quiz.prototype.render = function(container) {
  // For when we're out of scope
  var self = this;
  
  // Hide the quiz results modal
  $('#quiz-results').hide();
  
  // Write the name of the quiz
  $('#quiz-name').text(this.quiz_name);
  
  // Create a container for questions
  var question_container = $('<div>').attr('id', 'question').insertAfter('#quiz-name');
  
  // Helper function for changing the question and updating the buttons
  function change_question() {
    self.questions[current_question_index].render(question_container);
    $('#prev-question-button').prop('disabled', current_question_index === 0);
    $('#next-question-button').prop('disabled', current_question_index === self.questions.length - 1);
   
    
    // Determine if all questions have been answered
    var all_questions_answered = true;
    for (var i = 0; i < self.questions.length; i++) {
      if (self.questions[i].user_choice_index === null) {
        all_questions_answered = false;
        break;
      }
    }
    $('#submit-button').prop('disabled', !all_questions_answered);
  }
  
  // Render the first question
  var current_question_index = 0;
  change_question();
  
  // Add listener for the previous question button
  $('#prev-question-button').click(function() {
    if (current_question_index > 0) {
      current_question_index--;
      change_question();
    }
  });
 
  // Add listener for the next question button
  $('#next-question-button').click(function() {
    if (current_question_index < self.questions.length - 1) {
      current_question_index++;
      change_question();
    }
  for (var i = 0; i < self.questions.length; i++) {
     if (self.questions[i].user_choice_index === self.questions[i].correct_choice_index) {
        finalscore++;
      }
    }
  });
 
  // Add listener for the submit answers button
  $('#submit-button').click(function() {
    $("#quiz_time").hide();
    $("#quiz-name").hide();
    $("#question").hide();
    // Determine how many questions the user got right
    var score = 0;
    for (var i = 0; i < self.questions.length; i++) {
      if (self.questions[i].user_choice_index === self.questions[i].correct_choice_index) {
        score++;
      }
      
   $('#quiz-retry-button').click(function(reset) {
      quiz.render(quiz_container);
   });
    
    }
    
   
    
    // Display the score with the appropriate message
    var percentage = score / self.questions.length;
   
    var message;
    if (percentage === 1) {
      message = 'Great job!'
    } else if (percentage >= .75) {
      message = 'You did alright.'
    } else if (percentage >= .5) {
      message = 'Better luck next time.'
    } else {
      message = 'Maybe you should try a little harder.'
    }
    $('#quiz-results-message').text(message);
    results = score + '/' + self.questions.length;

    $('#quiz-results-score').html('You got <b>' + score + '/' + self.questions.length + '</b> questions correct.');
    alert((score/self.questions.length)*100);
    $.getJSON('{{route('api.question-score')}}',{
      'title':'{{$title}}',
      'score':Math.floor((score/self.questions.length)*100)
    },function(result){
      console.log(result);
    })
    $('#quiz-results').slideDown();
    $('#submit-button').slideUp();
    $('#next-question-button').slideUp();
    $('#prev-question-button').slideUp();
    $('#quiz-retry-button').sideDown();

    
  });
  
  // Add a listener on the questions container to listen for user select changes. This is for determining whether we can submit answers or not.
  question_container.bind('user-select-change', function() {
    var all_questions_answered = true;
    for (var i = 0; i < self.questions.length; i++) {
      if (self.questions[i].user_choice_index === null) {
        all_questions_answered = false;
        break;
      }
    }
    $('#submit-button').prop('disabled', !all_questions_answered);
  });
}

// An object for a Question, which contains the question, the correct choice, and wrong choices. This block is the constructor.
var Question = function(question_string, correct_choice, wrong_choices) {
  // Private fields for an instance of a Question object.
  this.question_string = question_string;
  this.choices = [];
  this.user_choice_index = null; // Index of the user's choice selection
  
  // Random assign the correct choice an index
  this.correct_choice_index = Math.floor(Math.random(0, wrong_choices.length + 1));
  
  // Fill in this.choices with the choices
  var number_of_choices = wrong_choices.length + 1;
  for (var i = 0; i < number_of_choices; i++) {
    if (i === this.correct_choice_index) {
      this.choices[i] = correct_choice;
    } else {
      // Randomly pick a wrong choice to put in this index
      var wrong_choice_index = Math.floor(Math.random(0, wrong_choices.length));
      this.choices[i] = wrong_choices[wrong_choice_index];
      
      // Remove the wrong choice from the wrong choice array so that we don't pick it again
      wrong_choices.splice(wrong_choice_index, 1);
    }
  }
}

// A function that you can enact on an instance of a question object. This function is called render() and takes in a variable called the container, which is the <div> that I will render the question in. This question will "return" with the score when the question has been answered.
Question.prototype.render = function(container) {
  // For when we're out of scope
  var self = this;
  
  // Fill out the question label
  var question_string_h2;
  if (container.children('h2').length === 0) {
    question_string_h2 = $('<h2>').appendTo(container);
  } else {
    question_string_h2 = container.children('h2').first();
  }
  question_string_h2.text(this.question_string);
  
  // Clear any radio buttons and create new ones
  if (container.children('input[type=radio]').length > 0) {
    container.children('input[type=radio]').each(function() {
      var radio_button_id = $(this).attr('id');
      $(this).remove();
      container.children('label[for=' + radio_button_id + ']').remove();
    });
  }
  for (var i = 0; i < this.choices.length; i++) {
    // Create the radio button
    var choice_radio_button = $('<input>')
      .attr('id', 'choices-' + i)
      .attr('type', 'radio')
      .attr('name', 'choices')
      .attr('value', 'choices-' + i)
      .attr('checked', i === this.user_choice_index)
      .appendTo(container);
    
    // Create the label
    var choice_label = $('<label>')
      .text(this.choices[i])
      .attr('for', 'choices-' + i)
      .appendTo(container);
  }
  
  // Add a listener for the radio button to change which one the user has clicked on
  $('input[name=choices]').change(function(index) {
    var selected_radio_button_value = $('input[name=choices]:checked').val();
    
    // Change the user choice index
    self.user_choice_index = parseInt(selected_radio_button_value.substr(selected_radio_button_value.length - 1, 1));
    
    // Trigger a user-select-change
    container.trigger('user-select-change');
  });
}

// "Main method" which will create all the objects and render the Quiz.
$(document).ready(function() {
  // Create an instance of the Quiz object
  var quiz = new Quiz('{{ucfirst($title)}} question  given below');
  
  // Create Question objects from all_questions and add them to the Quiz object
  for (var i = 0; i < all_questions.length; i++) {
    // Create a new Question object
    var question = new Question(all_questions[i].question_string, all_questions[i].choices.correct, all_questions[i].choices.wrong);
    
    // Add the question to the instance of the Quiz object that we created previously
    quiz.add_question(question);
  }
   $.getJSON('{{route('api.question-api')}}',{
    question_category_id:{{$id}}
   },
    function(result){ 
           //datas.push(result);
         $.each(result, function(i){
           quiz.add_question(new Question(result[i].question_string, result[i].choices.correct, result[i].choices.wrong));
         });
        
     });

  
  // Render the quiz
  var quiz_container = $('#quiz');
  quiz.render(quiz_container);
});

$("#quiz-end").hide();
  $("#quiz_time").TimeCircles({count_past_zero: false}).addListener(function(unit,value,total){
    if(total == 0){
      //alert(finalscore);
        window.location = "{{route('test-question-category')}}";
       // $("#result").html("<h1>Your score :"+finalscore+"</h1>");

       // $("#quiz-show").hide();
       // $("#quiz-end").show();

    }
  }) 
</script>
@endsection
