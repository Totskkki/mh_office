<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Search News Articles</h1>
    <input type="text" id="searchQuery" placeholder="Enter search query..." oninput="searchNews()">
    <div id="newsResults"></div>

    <script>
        function searchNews() {
            const query = document.getElementById("searchQuery").value.trim();

            // Don't search if the query is empty
            if (query === '') {
                document.getElementById("newsResults").innerHTML = '';
                return;
            }

            $.ajax({
                url: 'medical-news.php',  // Replace with your PHP file URL
                type: 'GET',
                data: { query: query },
                success: function(response) {
                    const resultContainer = document.getElementById("newsResults");

                    // Clear previous results
                    resultContainer.innerHTML = '';

                    if (response.success) {
                        // Loop through articles and display them
                        response.data.forEach(article => {
                            const articleElement = document.createElement('div');
                            articleElement.innerHTML = `
                                <h3>${article.title}</h3>
                                <p>${article.description}</p>
                                <a href="${article.url}" target="_blank">Read more</a>
                                <hr>
                            `;
                            resultContainer.appendChild(articleElement);
                        });
                    } else {
                        resultContainer.innerHTML = `<p>${response.message}</p>`;
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong. Please try again later.");
                }
            });
        }
    </script>
</body>
</html>
