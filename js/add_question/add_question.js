function showQuestionOptions(selectElement, questionOptionsContainer, questionnumber) 
{
  const questionCat = selectElement.value;

  questionOptionsContainer.innerHTML = '';

  if (questionCat === '1' || questionCat === '3' || questionCat === '4' || questionCat === '5') // 1 for SQ, 3 for LQ, 4 for T/F, 5 for Fill in Blank
  {
    const questionStatementTextarea = document.createElement('textarea');
    questionStatementTextarea.name = 'ques_statement['+ questionnumber + ']';
    questionStatementTextarea.value = '';
    questionStatementTextarea.className = 'form-control';
    questionStatementTextarea.placeholder = 'Question Statement';
    questionStatementTextarea.style.height = '100px!important';
    questionStatementTextarea.required = true;

    questionOptionsContainer.appendChild(questionStatementTextarea);
  } 
  else if (questionCat === '2') // 2 for MCQs
  {
    const questionStatementTextarea = document.createElement('input');
    questionStatementTextarea.type = 'text';
    questionStatementTextarea.name = 'ques_statement['+ questionnumber + ']';
    questionStatementTextarea.value = '';
    questionStatementTextarea.className = 'form-control req';
    questionStatementTextarea.placeholder = 'Question Title';
    questionStatementTextarea.style.marginBottom = '10px';
    questionStatementTextarea.required = true;

    const optionsContainer = document.createElement('div');
    optionsContainer.classList.add('options');

    for (let i = 1; i <= 5; i++) {
      const optionInput = document.createElement('input');
      optionInput.type = 'text';
      optionInput.name = 'option['+ questionnumber + '][' + i +']'; 
      optionInput.className = 'form-control';
      optionInput.placeholder = 'Option ' + i;
      optionInput.required = true;

      optionsContainer.appendChild(optionInput);
    }

    questionOptionsContainer.appendChild(questionStatementTextarea);
    questionOptionsContainer.appendChild(optionsContainer);
  }
}

let totalMarks = 0;
var quesid = 0;

function addQuestion(id_curs, id_prg) {
  quesid++;
  const questionContainer = document.getElementById('questionContainer');
  const questionCount = questionContainer.childElementCount; // Get the current question count

  // var quescontainerCount = document.getElementsByName("ques_Container"); // Get the count of a div
  // var count = quescontainerCount.length;
  
  const container = document.createElement('div');
  container.className = 'form-sep'
  container.style.width = '100%';
  container.style.border = '1px solid #E7E7E7';

  // Question number Selector
  const questionNumberContainer = document.createElement('div');
  questionNumberContainer.className = 'col-sm-31';
  questionNumberContainer.style.marginTop = "5px";

  const quesNumberLabel = document.createElement('label');
  quesNumberLabel.className = 'req';
  quesNumberLabel.textContent = 'Question Number:';

  const quesNumberSelect = document.createElement('select');
  quesNumberSelect.className = 'form-control req';
  quesNumberSelect.style.width = '100%';
  quesNumberSelect.name = 'ques_number[]';
  quesNumberSelect.required = true;

  const quesNumberOption = document.createElement('option');
  quesNumberOption.value = '';
  quesNumberOption.textContent = 'Select Question No.';
  quesNumberSelect.appendChild(quesNumberOption);

  for (let i = 1; i <= 15; i++) 
  {
    const quesNumberOption = document.createElement('option');
    quesNumberOption.value = i;
    quesNumberOption.textContent = i;
    quesNumberSelect.appendChild(quesNumberOption);
  }

  questionNumberContainer.appendChild(quesNumberLabel);
  questionNumberContainer.appendChild(quesNumberSelect);
  // Question Number Selector End

  // Question Type selector start 
  const questionTypeContainer = document.createElement('div');
  questionTypeContainer.className = 'col-sm-31';
  questionTypeContainer.style.marginTop = "5px";
 
  const quesCatLabel = document.createElement('label');
  quesCatLabel.textContent = 'Question Category:';

  const quesCatSelect = document.createElement('select');
  quesCatSelect.className = 'form-control req';
  quesCatSelect.name = 'ques_category[]';
  quesCatSelect.style.width = '100%';
  quesCatSelect.style.marginBottom = '10px';
  quesCatSelect.required = true;
  
  const quesCategoryOption = document.createElement('option');
  quesCategoryOption.value = '';
  quesCategoryOption.textContent = 'Select Question Cat.';
  quesCatSelect.appendChild(quesCategoryOption);

  var ques_catajaxreq = new XMLHttpRequest();
  ques_catajaxreq.open('GET', "functions/functions.php",true);
  ques_catajaxreq.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  ques_catajaxreq.send();
  ques_catajaxreq.onreadystatechange = function() {
    if (ques_catajaxreq.readyState === 4 && ques_catajaxreq.status === 200) {
      var options = JSON.parse(ques_catajaxreq.responseText);
      options.forEach(function(category) {
        const quesCategoryOption = document.createElement('option');
        quesCategoryOption.value = category.id;
        quesCategoryOption.textContent = category.name;
        quesCatSelect.appendChild(quesCategoryOption);
      });
    }
  };

  // call to showQuestionOption funtion 
  quesCatSelect.onchange = function() {
    showQuestionOptions(this, questionStatementContainer, questionCount);
  };
  
  questionTypeContainer.appendChild(quesCatLabel);
  questionTypeContainer.appendChild(quesCatSelect);
  // Question Type selector start END

  // Question Marks Selector Start
  const questionMarksContainer = document.createElement('div');
  questionMarksContainer.className = 'col-sm-31';
  questionMarksContainer.style.marginTop = "5px";

  const questionMarksLabel = document.createElement('label');
  questionMarksLabel.textContent = 'Marks:';

  const questionMarksSelect = document.createElement('select');
  questionMarksSelect.className = 'form-control req';
  questionMarksSelect.style.width = '100%';
  questionMarksSelect.name = 'ques_marks[]';
  questionMarksSelect.id = 'ques_marks';
  questionMarksSelect.required = true;

  const questionMarksOption = document.createElement('option');
  questionMarksOption.textContent = 'Select Marks';
  questionMarksOption.value = 0;
  questionMarksSelect.appendChild(questionMarksOption);

  for (let i = 1; i <= 10; i++) 
  {
    const questionMarksOption = document.createElement('option');
    questionMarksOption.value = i;
    questionMarksOption.textContent = i;
    questionMarksSelect.appendChild(questionMarksOption);
  }

  questionMarksContainer.appendChild(questionMarksLabel);
  questionMarksContainer.appendChild(questionMarksSelect);
  // Question Marks Selector End


  // Input field to display selected marks
  const selectedMarksInput = document.getElementById('total_marks');

  // Event listener for marks selector
  questionMarksSelect.addEventListener('change', function () 
  {
    // Update the sum of selected marks
    totalMarks = calculateTotalMarks();

    // Update the value of the input field
    selectedMarksInput.value = totalMarks;
  });

  // Function to calculate the sum of selected marks
  function calculateTotalMarks() 
  {  
    const marksSelectors = document.querySelectorAll('#ques_marks');
    
    let sum = 0;
    for (let i = 0; i < marksSelectors.length; i++) {
      sum += parseInt(marksSelectors[i].value);
    }
    return (sum);
  }
  // Question Marks Selector End


  // CLO Selector Start
  const cloSelector = document.createElement('div');
  cloSelector.className = 'col-sm-31';
  cloSelector.style.marginTop = "5px";

  const questionCloLabel = document.createElement('label');
  questionCloLabel.className = 'req';
  questionCloLabel.textContent = 'Mapped CLOs:';

  const questionCloSelect = document.createElement('select');
  questionCloSelect.className = '' ;
  questionCloSelect.style.width = '100%';
  questionCloSelect.name = 'ques_clo['+quesid+'][]';
  questionCloSelect.required = true;
  questionCloSelect.multiple = true;

  const questionCloOption = document.createElement('option');
  questionCloOption.value = '';
  questionCloOption.textContent = 'Select CLOs';
  questionCloSelect.appendChild(questionCloOption);

  var cloAjaxReq = new XMLHttpRequest();
  var method = "POST";
  var url = "include/ajax/get_cloOptions.php";
  var asynchronous = true;
  cloAjaxReq.open(method, url, asynchronous);

  var data = {
    id_curs: id_curs,
    id_prg: id_prg
  };
  var jsonData = JSON.stringify(data);
  cloAjaxReq.send(jsonData);

  cloAjaxReq.onreadystatechange = function() {
    if (cloAjaxReq.readyState === 4 && cloAjaxReq.status === 200) {
      const options = cloAjaxReq.responseText;
      questionCloSelect.innerHTML = options;
      console.log(cloAjaxReq.responseText);
    }
  };

  cloSelector.appendChild(questionCloLabel);
  cloSelector.appendChild(questionCloSelect);
  // CLO Selector End


  // Delete question Button Start

  const deletequestionButtonContainer = document.createElement('div');
  deletequestionButtonContainer.className = 'col-sm-31';
  deletequestionButtonContainer.style.marginTop = "5px";

  const deleteButtonContainer = document.createElement('div');
  deleteButtonContainer.style.display = 'flex';
  deleteButtonContainer.style.justifyContent =  'center';
  deleteButtonContainer.style.alignItems = 'center';
  deleteButtonContainer.style.margin = '15px  15px ';

  const deleteButton = document.createElement('button');
  deleteButton.type = 'button';
  deleteButton.style.width = '50%';
  deleteButton.style.alignItems = 'center';
  deleteButton.className = 'btn btn-danger';
  deleteButton.innerHTML = '<i class="icon-trash"></i>';



  deleteButton.addEventListener('click', function () {
    container.remove();
    // updateQuestionNumbers();
    totalMarks = calculateTotalMarks();
    selectedMarksInput.value = totalMarks;
  });

  deleteButtonContainer.appendChild(deleteButton);
  deletequestionButtonContainer.appendChild(deleteButtonContainer);

  // Delete question Button End

  const container1 = document.createElement('div');
  container1.style.clear = 'both';

  // Question Statment/Options Start

  const container2 = document.createElement('div');
  container2.className = 'form-group questionStatementContainer';
  container2.id = "questionStatementContainer";
  container2.style.marginTop = '5px';

  const questionStatementContainer = document.createElement('div');
  questionStatementContainer.className = 'col-sm-12';
  questionStatementContainer.style.marginTop = '5px';

  container2.appendChild(questionStatementContainer);

  // Question Statment/Options End

  // container.appendChild(questionNumber);
  container.appendChild(questionNumberContainer);
  container.appendChild(questionTypeContainer);
  container.appendChild(questionMarksContainer);
  container.appendChild(cloSelector);
  container.appendChild(deletequestionButtonContainer);
  container.appendChild(container1);
  container.appendChild(container2);
  questionContainer.appendChild(container); 

}

$(".select2").select2({
  placeholder: "Select Any Option"
})








