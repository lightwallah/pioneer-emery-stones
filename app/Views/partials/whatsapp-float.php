<?php
$waMessage = $lang === 'hi'
    ? 'नमस्ते Pioneer Emery Stones, मुझे आपके उत्पादों के बारे में जानकारी चाहिए।'
    : 'Hello Pioneer Emery Stones, I would like to inquire about your emery stone products.';
?>
<a href="<?= whatsapp_link($waMessage) ?>" class="whatsapp-float" target="_blank" rel="noopener" title="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
