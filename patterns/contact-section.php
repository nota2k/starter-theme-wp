<?php
/**
 * Title: Section contact
 * Slug: theme-moderne/contact-section
 * Description: Section complète avec informations de contact et formulaire
 * Categories: theme-moderne
 * Keywords: contact, form, info
 * Viewport Width: 1200
 * Block Types: core/group
 * Inserter: yes
 */
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"gray-50","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-gray-50-background-color has-background" style="padding-top:4rem;padding-bottom:4rem">
    <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"3rem","fontWeight":"700"}},"textColor":"gray-900"} -->
    <h2 class="wp-block-heading has-text-align-center has-gray-900-color has-text-color" style="font-size:3rem;font-weight:700">Contactez-nous</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"}},"textColor":"gray-600"} -->
    <p class="has-text-align-center has-gray-600-color has-text-color" style="font-size:1.25rem">Prêt à démarrer votre projet ? Parlons-en ensemble !</p>
    <!-- /wp:paragraph -->

    <!-- wp:spacer {"height":"3rem"} -->
    <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"2rem"}}}} -->
    <div class="wp-block-columns">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"1rem"}},"backgroundColor":"white","className":"contact-info-card shadow-md"} -->
            <div class="wp-block-group contact-info-card shadow-md has-white-background-color has-background" style="border-radius:1rem;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem","fontWeight":"700"}},"textColor":"gray-900"} -->
                <h3 class="wp-block-heading has-gray-900-color has-text-color" style="font-size:1.5rem;font-weight:700">Nos coordonnées</h3>
                <!-- /wp:heading -->

                <!-- wp:spacer {"height":"1.5rem"} -->
                <div style="height:1.5rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <div class="contact-info-item">
                    <strong>📍 Adresse</strong><br>
                    123 Rue de l'Innovation<br>
                    75001 Paris, France
                </div>
                <!-- /wp:html -->

                <!-- wp:spacer {"height":"1rem"} -->
                <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <div class="contact-info-item">
                    <strong>📞 Téléphone</strong><br>
                    <a href="tel:+33123456789">+33 1 23 45 67 89</a>
                </div>
                <!-- /wp:html -->

                <!-- wp:spacer {"height":"1rem"} -->
                <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <div class="contact-info-item">
                    <strong>✉️ Email</strong><br>
                    <a href="mailto:contact@example.com">contact@example.com</a>
                </div>
                <!-- /wp:html -->

                <!-- wp:spacer {"height":"1rem"} -->
                <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <div class="contact-info-item">
                    <strong>🕒 Horaires</strong><br>
                    Lun - Ven : 9h00 - 18h00<br>
                    Sam : 9h00 - 12h00
                </div>
                <!-- /wp:html -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"1rem"}},"backgroundColor":"white","className":"contact-form-card shadow-md"} -->
            <div class="wp-block-group contact-form-card shadow-md has-white-background-color has-background" style="border-radius:1rem;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem","fontWeight":"700"}},"textColor":"gray-900"} -->
                <h3 class="wp-block-heading has-gray-900-color has-text-color" style="font-size:1.5rem;font-weight:700">Envoyez-nous un message</h3>
                <!-- /wp:heading -->

                <!-- wp:spacer {"height":"1.5rem"} -->
                <div style="height:1.5rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <form class="contact-form">
                    <div class="form-group">
                        <label for="contact-name">Nom complet *</label>
                        <input type="text" id="contact-name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email">Email *</label>
                        <input type="email" id="contact-email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-subject">Sujet</label>
                        <input type="text" id="contact-subject" name="subject">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" rows="4" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">Envoyer le message</button>
                </form>
                <!-- /wp:html -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->