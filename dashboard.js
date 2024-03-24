const showExpenseForm = document.getElementById("showExpenseForm");
const expenseForm = document.getElementById("expenseForm");
const expenseEntryForm = document.getElementById("expenseEntryForm");
const statusSelect = document.getElementById("status");
const paidAmountContainer = document.getElementById("paidAmountContainer");
const expenseTableBody = document.getElementById("expenseTableBody");
let entryCount = 1;

showExpenseForm.addEventListener("click", () => {
    showExpenseForm.style.display = "none"; // Hide the button
    expenseForm.style.display = "block";
});

const hideExpenseForm = () => {
    showExpenseForm.style.display = "block"; // Show the button
    expenseForm.style.display = "none";
    expenseEntryForm.reset();
};

statusSelect.addEventListener("change", () => {
    if (statusSelect.value === "partiallyPaid") {
        paidAmountContainer.style.display = "block";
    } else {
        paidAmountContainer.style.display = "none";
    }
});

document.getElementById("cancel").addEventListener("click", hideExpenseForm);

 // document.getElementById("submit").addEventListener("click", () => {
    //     const category = document.getElementById("category").value;
    //     const total_expense = document.getElementById("total_expense").value;
    //     const issued_date = document.getElementById("issued_date").value;
    //     const status = document.getElementById("status").value;

    //     if (category && total_expense && issued_date && status) {
    //         // Create a new expense entry
    //         const newRow = document.createElement('tr');
    //         newRow.innerHTML = `
    //             <td>#${entryCount}</td>
    //             <td>
    //                 <div class="client">
    //                     <div class="client-img bg-img" style="background-image: url('img/1.jpeg')"></div>
    //                     <div class="client-info">
    //                         <h4>Arunabh Shikhar</h4>
    //                         <small>${category}</small>
    //                         </div>
    //                         </div>
    //             </td>
    //             <td>Rs ${total_expense}</td>
    //             <td>${issued_date}</td>
    //             <td>${status}</td>
    //             <td>
    //                 <div class="actions">
    //                     <span class="lab la-telegram-plane"></span>
    //                     <span class="las la-eye"></span>
    //                     <span class="las la-ellipsis-v"></span>
    //                     </div>
    //                     </td>
    //                     `;
    //                     entryCount++;
                        
    //                     // Append the new row to the table body
    //                     expenseTableBody.appendChild(newRow);

    //         // Reset the form and hide it
    //         hideExpenseForm();
    //     } else {
    //         alert("Please fill in all the details.");
    //     }
    // });