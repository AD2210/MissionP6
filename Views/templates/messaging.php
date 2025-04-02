<?php
/**
 * Page d'affichage de la messagerie
 */
?>

<section class="messagingSection">
    <div class="messagingContainer">
        <div class="inbox">
            <h1>Messagerie</h1>
            <div class="inboxContent">
                <?php
                //Affichage partie Inbox
                foreach ($LastMessagesWithUsers as $lastMessage){
                    //Variable pour HereDoc
                    $idCorresponding = $lastMessage['idSender'];
                    $avatar = $lastMessage['avatar'];
                    $pseudo = $lastMessage['pseudo'];
                    $dateLastMessage = Service::dateFormater($lastMessage['sendDate'],'H:i');
                    $messageReadClass = $lastMessage['readFlag'] ? 'read' : 'unread'; //affecte la classe correspondante si le message est lu ou non 
                    $contentLastMessage = $lastMessage['content'];
                    $selectedThreadClass = $idCorresponding == $correspondingUser->getId() ? 'selectedThread' : 'otherThread';

                    //Template de l'inbox avec intégration des variables
                    $messaging = <<<HTML
                        <a href="index.php?action=messaging&corresponding=$idCorresponding">
                            <div class="inboxContainer $selectedThreadClass">
                                <img class ="avatarMedium" src="$avatar" alt="photo du membre : $pseudo">
                                <div class ="inboxContainerContent">  
                                    <div class="inboxContentInformations">
                                        <p class="$messageReadClass">$pseudo</p>
                                        <p>$dateLastMessage</p>
                                    </div>
                                    <p class ="textOverFlow">$contentLastMessage</p>
                                </div>  
                            </div>
                        </a>
                    HTML;
                    echo $messaging; // On affiche le template
                }
                ?>
            </div>
        </div>

        <?php
            //Affichage de la partie Fil de discussion
            
            //On récupère les variable pour HereDoc et on génère le template pour la carte pseudo + avatar
            $avatar = $correspondingUser->getAvatar();
            $pseudo = $correspondingUser->getPseudo();
            $correspondingId = $correspondingUser->getId();

            $sender = <<<HTML
                <div class="senderAvatar">
                    <img class ="avatarMedium" src="$avatar" alt="photo du membre : $pseudo">
                    <p>$pseudo</p>
                </div>
            HTML;
        ?>
        <div class="messageTreadSection">
            <?= $sender; //On affiche le template avec les variables ?>  
            <div Class="messageTreadContainer">
                <?php
                    foreach ($messageThread as $message){
                        // Varaibles pour HereDoc
                        $sendDate = Service::dateFormater($message->getSendDate(),'d.m H:i');
                        $messageContent = $message->getContent();
                        $messageClass = $user->getId() == $message->getIdReceiver() ? 'receivedMessage' : 'sendMessage';
                        $avatarClass = $messageClass == 'receivedMessage' ? 'showAvatar' : 'hideAvatar';
                        $messageContainerClass = $messageClass == 'receivedMessage' ? 'receivedContainer' : 'sendContainer';

                        //Template du fil de discussion avec intégration des variables
                        $showMessages = <<<HTML
                            <div class="$messageContainerClass">
                                <div class="senderInformation $avatarClass ">
                                    <img class ="avatarSmall" src="$avatar" alt="">
                                    <span>$sendDate</span>
                                </div>
                                <div class="message $messageClass">
                                    <p>$messageContent</p>
                                </div>
                            </div>
                        HTML;
                        echo $showMessages; // on affiche le template
                    }
                ?>
            </div>
            <form class = "messagingForm" action="index.php?action=newMessage" method="POST">
                <input type="hidden" name="correspondingId" id="correspondingId" value="<?= $correspondingId ?>"/>
                <input type ="text" name="message" id="message" placeholder="Tapez votre message ici"/>
                <button class="button" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</section>




