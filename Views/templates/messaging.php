<section>
    <div>
        <h1>Messagerie</h1>
        <?php
        // page d'affichage de la messagerie

        foreach ($messagesLastReceived as $message){
            //$avatar = $corresponding->getAvatar();
            //$pseudo = $corresponding->getPseudo();
            $lastMessage = MessageManager::getLastMessagesFromOneSenderByIdReceiver(
                $user->getId(),
                $corresponding->getId()
            );
            $dateLastMessage = $lastMessage->getSendDateStringFormat('H:i');
            $messageRead = $corresponding->getReadFlag() ? 'read' : 'unread'; //affecte la classe correspondante si le message est lu ou non 

            $messaging = <<<HTML
                <div class="messagingContainer">
                    <img src="$avatr" alt="photo du membre : $pseudo">
                    <div>  
                        <div>
                            <p>$pseudo</p>
                            <p>$dateLastMessage</p>
                        </div>
                        <span>$lastMessage</span>
                    </div>  
                </div>
            HTML;
            echo $messaging;
        }

        ?>
    </div>

    <?php
        $avatar = $idReceiver->getAvatar(); // jeu de donnée à construire pour le fil de discussion
        $pseudo = $idReceiver->getPseudo();
        $idReceiver = $idReceiver->getIdReceiver();

        $receiver = <<<HTML
            <div>
                <img src="$avatar" alt="photo du membre : $pseudo">
                <p>$pseudo</p>
            </div>
        HTML;
    ?>
    <div>
        <?= $receiver; ?>
        <div>
            <?php
                foreach ($messages as $message){
                    $sendDate = $message->getSendDate();
                    $messageContent = $message->getContent();
                    $messageClass = $idReceiver == $message->getIdReceiver() ? 'receivedMessage' : 'sendMessage';
                    $avatarClass = $messageClass == 'receivedMessage' ? 'showAvatar' : 'hideAvatar';

                    $showMessages = <<<HTML
                        <div>
                            <div>
                                <img class ="$avatarClass" src="$avatar" alt="">
                                <span>$sendDate</span>
                            </div>
                            <div class="$messageClass">
                                <p>$messageContent</p>
                            </div>
                        </div>
                    HTML;
                    echo $showMessages;
                }
            ?>
        </div>
        <form action="#">
            <textarea name="message" id="message" placeholder="Tapez votre message ici"></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</section>



