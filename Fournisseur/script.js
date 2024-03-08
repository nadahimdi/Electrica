
    document.addEventListener("DOMContentLoaded", function () {
        // Get all the dashboard items
        var dashboardItems = document.querySelectorAll('.side-menu li');

        // Add click event listeners to each dashboard item
        dashboardItems.forEach(function (item) {
            item.addEventListener('click', function () {
                // Remove 'active' class from all items
                dashboardItems.forEach(function (otherItem) {
                    otherItem.classList.remove('active');
                });

                // Add 'active' class to the clicked item
                item.classList.add('active');
            });
        });
    });


    



