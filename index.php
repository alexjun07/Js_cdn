<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<style>


</style>

<body>
    <!-- Chatbot -->
    <div class="botIcon">
        <div class="botIconContainer">
            <div class="iconInner">
                <i class="fa fa-commenting" aria-hidden="true"></i>
            </div>
        </div>
        <div class="Layout Layout-open Layout-expand Layout-right">
            <div class="Messenger_messenger">
                <div class="Messenger_header">
                    <h4 class="Messenger_prompt">How can we help you?</h4> <span class="chat_close_icon"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                </div>
                <div class="Messenger_content">
                    <div class="Messages">
                        <div class="Messages_list"></div>
                    </div>
                    <form id="messenger" method="Post" enctype="multipart/form-data" action="send_mail.php">
                        <div class="Input Input-blank">
                            <!-- 							<textarea name="msg" class="Input_field" placeholder="Send a message..."></textarea> -->
                            <input name="msg" class="Input_field" placeholder="Send a message...">
                            <button type="submit" class="Input_button Input_button-send">
                                <div class="Icon">
                                    <svg viewBox="1496 193 57 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="Group-9-Copy-3" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(1523.000000, 220.000000) rotate(-270.000000) translate(-1523.000000, -220.000000) translate(1499.000000, 193.000000)">
                                            <path d="M5.42994667,44.5306122 L16.5955554,44.5306122 L21.049938,20.423658 C21.6518463,17.1661523 26.3121212,17.1441362 26.9447801,20.3958097 L31.6405465,44.5306122 L42.5313185,44.5306122 L23.9806326,7.0871633 L5.42994667,44.5306122 Z M22.0420732,48.0757124 C21.779222,49.4982538 20.5386331,50.5306122 19.0920112,50.5306122 L1.59009899,50.5306122 C-1.20169244,50.5306122 -2.87079654,47.7697069 -1.64625638,45.2980459 L20.8461928,-0.101616237 C22.1967178,-2.8275701 25.7710778,-2.81438868 27.1150723,-0.101616237 L49.6075215,45.2980459 C5.08414042,47.7885641 49.1422456,50.5306122 46.3613062,50.5306122 L29.1679835,50.5306122 C27.7320366,50.5306122 26.4974445,49.5130766 26.2232033,48.1035608 L24.0760553,37.0678766 L22.0420732,48.0757124 Z" id="sendicon" fill="#96AAB4" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Chatbot -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    jQuery(document).ready(function($) {
    // Function to scroll to the latest message
    function scrollToBottom() {
        let msgList = $('.Messages');
        msgList.animate({ scrollTop: msgList.prop("scrollHeight") }, 800); // Smooth scrolling to bottom
    }

    // Prevent scrolling on focus for inputs and selects
    function preventAutoScrollOnFocus() {
        $(document).on('focus', 'input, select', function(e) {
            e.preventDefault();
        });
    }

    preventAutoScrollOnFocus();

    jQuery(document).on('click', '.iconInner', function(e) {
        jQuery(this).parents('.botIcon').addClass('showBotSubject');
        $("[name='msg']").focus();
    });

    jQuery(document).on('click', '.closeBtn, .chat_close_icon', function(e) {
        jQuery(this).parents('.botIcon').removeClass('showBotSubject');
        jQuery(this).parents('.botIcon').removeClass('showMessenger');
    });

    jQuery(document).on('submit', '#botSubject', function(e) {
        e.preventDefault();
        jQuery(this).parents('.botIcon').removeClass('showBotSubject');
        jQuery(this).parents('.botIcon').addClass('showMessenger');
    });

    let conversationStage = 0;
    let name = '';
    let travelTime = '';
    let travelPeople = '';
    let experience = '';
    let contactNumber = '';
    let chatHistory = [];

    function userMsg(msg) {
        $('.Messages_list').append('<div class="msg user"><span class="responsText usertext">' + msg + '</span></div>');
        chatHistory.push({
            sender: "user",
            message: msg
        });
        scrollToBottom(); // Ensure scroll after user message
    }

    function appendMsg(msg) {
        $('.Messages_list').append('<div class="msg typing"><div class="typingIndicator"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></div>');
        scrollToBottom(); // Scroll after typing indicator appears

        setTimeout(function() {
            $('.Messages_list').find('.typing').remove();
            $('.Messages_list').append('<div class="msg"><span class="responsText">' + msg + '</span></div>');
            chatHistory.push({ sender: "bot", message: msg });
            scrollToBottom(); // Scroll after bot message
        }, 2000);
    }

    appendMsg("Welcome to KBS Travels! 😄 Before we start, could you tell me your name?");
    conversationStage = 1;

    $(document).on("submit", "#messenger", function(e) {
        e.preventDefault();
        let val = $("[name=msg]").val().toLowerCase();
        let mainval = $("[name=msg]").val();

        userMsg(mainval);

        $("[name=msg]").val(''); // Clear the input field

        switch (conversationStage) {
            case 1:
                name = mainval;
                appendMsg("Where can I contact you if the chat gets disconnected?");
                conversationStage = 1.5;
                break;
            case 1.5:
                if (/^\d{10}$/.test(mainval)) {
                    contactNumber = mainval;
                    appendMsg("Awesome, " + name + "! How soon are you planning to travel?");
                    appendMsg("<select id='travelTimeSelect' class='form-select'><option value='select month'>--Select Month--</option><option value='nextMonth'>In the next month</option><option value='1-3Months'>1-3 months</option><option value='3-6Months'>3-6 months</option><option value='browsing'>Just browsing for now</option></select>");

                    scrollToBottom(); // Scroll after dropdown is appended

                    // Move dropdown change event inside the switch block to prevent multiple event bindings
                    $(document).off("change", "#travelTimeSelect").on("change", "#travelTimeSelect", function() {
                        travelTime = $(this).val();
                        $("[name=msg]").val(travelTime);
                        conversationStage = 2;
                        $("#messenger").submit(); 
                    });
                } else {
                    appendMsg("Please enter a valid 10-digit contact number.");
                }
                break;
            case 2:
                appendMsg("Great! How many people will be traveling with you?");
                appendMsg("<select id='travelPeopleSelect' class='form-select'><option value='selectpeople'>--Select People--</option><option value='just Me'>Just me</option><option value='2 People'>2 people</option><option value='3+ People'>3+ people</option></select>");
                
                scrollToBottom(); // Scroll after dropdown is appended

                $(document).off("change", "#travelPeopleSelect").on("change", "#travelPeopleSelect", function() {
                    travelPeople = $(this).val();
                    $("[name=msg]").val(travelPeople);
                    conversationStage = 3;
                    $("#messenger").submit(); 
                });
                break;
            case 3:
                appendMsg("What type of experience are you looking for?");
                appendMsg("<select id='experienceSelect' class='form-select'><option value='Select Experience'>--Select Experience--</option><option value='luxury'>Luxury</option><option value='Family-friendly'>Family-friendly</option><option value='Adventure-Packed'>Adventure-packed</option><option value='relaxing'>Relaxing/Leisure</option></select>");
                
                scrollToBottom(); // Scroll after dropdown is appended

                $(document).off("change", "#experienceSelect").on("change", "#experienceSelect", function() {
                    experience = $(this).val();
                    $("[name=msg]").val(experience);
                    conversationStage = 4;
                    $("#messenger").submit(); 
                });
                break;

                case 4:
    appendMsg("I’ve got some great recommendations for you! Before we move forward, could I get your contact details so one of our travel experts can share personalized packages with you?");
    
    // Hide the messenger input field
    $("[name=msg]").hide(); 

    // Append the form for name, email, and phone
    $('.Messages_list').append(`
        <div class="msg">
            <form id="contactForm">
                <input type="text" class='form-control' name="name" placeholder="Your Name" required />
                <br>
                <input type="email" class='form-control' name="email" placeholder="Your Email" required />
                <br>
                <input type="tel" class='form-control' name="phone" placeholder="Your Phone" required pattern="[0-9]{10}" />
                <br>
                <button type="submit" class='btn btn-primary'>Submit</button>
            </form>
        </div>
    `);
    scrollToBottom(); // Scroll to the bottom after appending the form

    // Handle form submission
    $(document).off("submit", "#contactForm").on("submit", "#contactForm", function(e) {
        e.preventDefault();
        
        // Gather form data
        const formData = $(this).serializeArray();
        const userData = {};
        formData.forEach(item => {
            userData[item.name] = item.value;
        });

        // Send data via AJAX (adjust URL if needed)
        $.ajax({
            url: "send_mail.php",
            method: "POST",
            data: {
                chatData: JSON.stringify(chatHistory),
                name: userData.name,
                email: userData.email,
                phone: userData.phone,
                contact: contactNumber // Use previously collected contact number if needed
            },
            success: function(response) {
                appendMsg("Thank you for your details! A travel expert will contact you shortly.");
                console.log("Mail sent successfully!");
            },
            error: function() {
                appendMsg("Failed to send your details. Please try again.");
                console.log("Failed to send mail.");
            }
        });

        // Reset conversation stage
        conversationStage = 0; 
        $(this).remove(); // Remove the form after submission
    });

    conversationStage = 5; // Update the stage to indicate we are now waiting for the form input
    break;


            case 5:
                appendMsg("Perfect! Your travel expert will be in touch shortly.");
                $("[name=msg]").hide();
                appendMsg("Thank you!");

                $.ajax({
                    url: "send_mail.php",
                    method: "POST",
                    data: {
                        chatData: JSON.stringify(chatHistory),
                        name: name,
                        contact: contactNumber
                    },
                    success: function(response) {
                        console.log("Mail sent successfully!");
                    },
                    error: function() {
                        console.log("Failed to send mail.");
                    }
                });

                conversationStage = 0;
                break;
            default:
                appendMsg("Sorry, I didn't understand that.");
        }
    });
});


    </script>
</body>

</html>