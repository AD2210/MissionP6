<section class="messagingSection">
    <div class="inbox">
        <h1>Messagerie</h1>
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
                    <img src="$avatar" alt="photo du membre : $pseudo">
                    <div class="inboxContent">  
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

    <?php
        // $avatar = $idReceiver->getAvatar(); // jeu de donnée à construire pour le fil de discussion
        // $pseudo = $idReceiver->getPseudo();
        // $idReceiver = $idReceiver->getIdReceiver();

        // $receiver = <<<HTML
        //     <div>
        //         <img src="$avatar" alt="photo du membre : $pseudo">
        //         <p>$pseudo</p>
        //     </div>
        // HTML;
    ?>
    <!-- <div>
        <div>
            <?php
            //$receiver
                // foreach ($messages as $message){
                //     $sendDate = $message->getSendDate();
                //     $messageContent = $message->getContent();
                //     $messageClass = $idReceiver == $message->getIdReceiver() ? 'receivedMessage' : 'sendMessage';
                //     $avatarClass = $messageClass == 'receivedMessage' ? 'showAvatar' : 'hideAvatar';

                //     $showMessages = <<<HTML
                //         <div>
                //             <div>
                //                 <img class ="$avatarClass" src="$avatar" alt="">
                //                 <span>$sendDate</span>
                //             </div>
                //             <div class="$messageClass">
                //                 <p>$messageContent</p>
                //             </div>
                //         </div>
                //     HTML;
                //     echo $showMessages;
                // }
            ?>
        </div>
        <form action="#">
            <textarea name="message" id="message" placeholder="Tapez votre message ici"></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div> -->
</section>



