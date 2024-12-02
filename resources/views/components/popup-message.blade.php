<div>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Display success message using Notiflix Report without background color
                Notiflix.Report.success(
                    'Success!',
                    '{{ session('success') }}',
                    'OK',
                    {
                        messageMaxLength: 400,
                        plainText: true, // This option can help make it look simpler
                        cssAnimationStyle: 'zoom', // Optional, to enhance presentation without too much distraction
                        backOverlay: false, // This disables the background overlay
                        success: {
                            backgroundColor: 'transparent', // Ensuring the success message has no background
                            textColor: '#333', // Set the text color as desired (default: black)
                        }
                    }
                );
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Display error message using Notiflix Report without background color
                Notiflix.Report.failure(
                    'Error!',
                    '{{ session('error') }}',
                    'OK',
                    {
                        messageMaxLength: 400,
                        plainText: true,
                        cssAnimationStyle: 'zoom',
                        backOverlay: false,
                        failure: {
                            backgroundColor: 'transparent',
                            textColor: '#333',
                        }
                    }
                );
            });
        </script>
    @endif
</div>
