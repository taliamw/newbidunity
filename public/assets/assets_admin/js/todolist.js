(function($) {
    'use strict';
    $(function() {
      var todoListItem = $('.todo-list');
      var todoListInput = $('.todo-list-input');

      // Function to add a new task
      $('.todo-list-add-btn').on("click", function(event) {
        event.preventDefault();

        var item = todoListInput.val().trim(); // Get the task text

        if (item !== '') {
          // Create a new task item with a delete button
          var newTask = `<li>
                            <div class='form-check form-check-primary'>
                                <label class='form-check-label'>
                                    <input class='checkbox' type='checkbox'> ${item}
                                </label>
                            </div>
                            <i class='remove mdi mdi-close-box'></i>
                         </li>`;

          todoListItem.append(newTask); // Append the new task to the list
          todoListInput.val(""); // Clear the input field after adding a task
        }
      });

      // Event delegation to handle changes in checkboxes
      todoListItem.on('change', '.checkbox', function() {
        $(this).closest("li").toggleClass('completed', this.checked);
      });

      // Event delegation to handle task deletion
      todoListItem.on('click', '.remove', function() {
        $(this).parent().remove(); // Remove the task when the remove button is clicked
      });

    });
  })(jQuery);
