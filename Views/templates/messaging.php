<section class="messagingSection">
    <div class="inbox">
        <h1>Messagerie</h1>
        <div class="inboxContent">
            <?php
            //page d'affichage de la messagerie
            foreach ($LastMessagesWithUsers as $lastMessage){
                $avatar = $lastMessage['avatar'];
                $pseudo = $lastMessage['pseudo'];
                $dateLastMessage = Message::getSendDateStringFormat($lastMessage['sendDate'],'H:i');
                $messageReadClass = $lastMessage['readFlag'] ? 'read' : 'unread'; //affecte la classe correspondante si le message est lu ou non 
                $contentLastMessage = Message::stringTrucator($lastMessage['content'],28);

                $messaging = <<<HTML
                    <div class="inboxContainer $messageReadClass">
                        <img class ="avatarMedium" src="$avatar" alt="photo du membre : $pseudo">
                        <div class="inboxContainerContent">  
                            <div class="inboxContentInformations">
                                <p>$pseudo</p>
                                <p>$dateLastMessage</p>
                            </div>
                            <span>$contentLastMessage</span>
                        </div>  
                    </div>
                HTML;
                echo $messaging;
            }
            ?>
        </div>
    </div>

    <?php
        $avatar = $correspondingUser->getAvatar();
        $pseudo = $correspondingUser->getPseudo();

        $sender = <<<HTML
            <div class="senderAvatar">
                <img class ="avatarMedium" src="$avatar" alt="photo du membre : $pseudo">
                <p>$pseudo</p>
            </div>
        HTML;
    ?>
    <div class="messageTreadSection">
        <?= $sender;?>
        <div Class="messageTreadContainer">
            <?php
                foreach ($messageThread as $message){
                    $sendDate = Message::getSendDateStringFormat($message->getSendDate(),'d.m H:i');
                    $messageContent = $message->getContent();
                    $messageClass = $user->getId() == $message->getIdReceiver() ? 'receivedMessage' : 'sendMessage';
                    $avatarClass = $messageClass == 'receivedMessage' ? 'showAvatar' : 'hideAvatar';
                    $messageContainerClass = $messageClass == 'receivedMessage' ? 'receivedContainer' : 'sendContainer';

                    $showMessages = <<<HTML
                        <div class="$messageContainerClass">
                            <div class="senderInformation $avatarClass">
                                <img class ="avatarSmall" src="$avatar" alt="">
                                <span>$sendDate</span>
                            </div>
                            <div class="message $messageClass">
                                <p>$messageContent</p>
                            </div>
                        </div>
                    HTML;
                    echo $showMessages;
                }
            ?>
        </div>
        <form class = "messagingForm" action="#">
            <input type ="text" name="message" id="message" placeholder="Tapez votre message ici"></input>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</section>



