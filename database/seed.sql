-- Seed data for Pioneer Emery Stones
USE pioneer_emery_stones;

-- Admin (username: admin, password: password — change after first login)
INSERT INTO admins (username, password, name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Pioneer Emery Stones'),
('phone', '+91-9414195145'),
('phone_secondary', '+91-9314713445'),
('contact_person', 'R.S. Suthar'),
('gst_number', '08BEZPS6751J1ZE'),
('email', 'info@pioneeremerystones.com'),
('whatsapp_number', '919414195145'),
('address', 'Plot No. 18, Khashra No. 109/110, Mogarakalla, NH-65, Pali Road, Jodhpur, Rajasthan'),
('google_map_embed', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.0!2d75.7873!3d26.9124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjbCsDU0JzQ0LjYiTiA3NcKwNDcnMTQuMyJF!5e0!3m2!1sen!2sin!4v1" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'),
('google_analytics', ''),
('google_search_console', ''),
('facebook_url', ''),
('instagram_url', ''),
('years_experience', '30'),
('track_delivery_url', ''),
('site_logo', ''),
('hero_image', '');

-- Categories
INSERT INTO categories (slug, sort_order) VALUES
('natraj-emery-stones', 1),
('surabhi-emery-stones', 2),
('ravi-emery-stones', 3),
('savaliya-emery-stones', 4),
('other-emery-stone-products', 5);

INSERT INTO category_translations (category_id, lang, name, description, meta_title, meta_description) VALUES
(1, 'en', 'Natraj Emery Stones', 'Premium Natraj brand emery stones for flour mills.', 'Natraj Emery Stone Manufacturer | Pioneer Emery Stones', 'Buy Natraj Emery Stones from Pioneer - trusted manufacturer in Rajasthan, India.'),
(1, 'hi', 'नटराज इमेरी स्टोन्स', 'आटा चक्की के लिए प्रीमियम नटराज इमेरी स्टोन्स।', 'नटराज इमेरी स्टोन निर्माता | Pioneer Emery Stones', 'पायनियर से नटराज इमेरी स्टोन्स खरीदें - राजस्थान, भारत के विश्वसनीय निर्माता।'),
(2, 'en', 'Surabhi Emery Stones', 'High-quality Surabhi emery stones for atta chakki.', 'Surabhi Emery Stone Supplier India | Pioneer', 'Surabhi Emery Stones for flour mills - durable and efficient grinding.'),
(2, 'hi', 'सुरभि इमेरी स्टोन्स', 'आटा चक्की के लिए उच्च गुणवत्ता वाली सुरभि इमेरी स्टोन्स।', 'सुरभि इमेरी स्टोन आपूर्तिकर्ता भारत', 'आटा चक्की के लिए सुरभि इमेरी स्टोन्स।'),
(3, 'en', 'Ravi Emery Stones', 'Ravi brand emery stones - reliable grinding performance.', 'Ravi Emery Stone Manufacturer', 'Ravi Emery Stones for industrial and commercial flour mills.'),
(3, 'hi', 'रवि इमेरी स्टोन्स', 'रवि ब्रांड इमेरी स्टोन्स - विश्वसनीय पीसने का प्रदर्शन।', 'रवि इमेरी स्टोन निर्माता', 'औद्योगिक आटा चक्की के लिए रवि इमेरी स्टोन्स।'),
(4, 'en', 'Savaliya Emery Stones', 'Savaliya emery stones for superior flour quality.', 'Savaliya Emery Stone Supplier', 'Savaliya Emery Stones - premium quality from Pioneer.'),
(4, 'hi', 'सवलिया इमेरी स्टोन्स', 'बेहतर आटे की गुणवत्ता के लिए सवलिया इमेरी स्टोन्स।', 'सवलिया इमेरी स्टोन आपूर्तिकर्ता', 'पायनियर से प्रीमियम सवलिया इमेरी स्टोन्स।'),
(5, 'en', 'Other Emery Stone Products', 'Additional emery stone products and accessories.', 'Other Emery Stone Products', 'Explore other emery stone products from Pioneer.'),
(5, 'hi', 'अन्य इमेरी स्टोन उत्पाद', 'अतिरिक्त इमेरी स्टोन उत्पाद और सामान।', 'अन्य इमेरी स्टोन उत्पाद', 'पायनियर के अन्य इमेरी स्टोन उत्पाद देखें।');

-- Products
INSERT INTO products (category_id, slug, sku, is_featured, sort_order) VALUES
(1, 'natraj-emery-stone-14-inch', 'NAT-14', 1, 1),
(1, 'natraj-emery-stone-16-inch', 'NAT-16', 1, 2),
(2, 'surabhi-emery-stone-14-inch', 'SUR-14', 1, 3),
(3, 'ravi-emery-stone-18-inch', 'RAV-18', 1, 4),
(4, 'savaliya-emery-stone-16-inch', 'SAV-16', 0, 5);

INSERT INTO product_translations (product_id, lang, name, short_description, description, benefits, applications, meta_title, meta_description) VALUES
(1, 'en', 'Natraj Emery Stone 14 Inch', 'Premium 14 inch Natraj emery stone for atta chakki.', 'Our Natraj 14 inch emery stone is crafted with precision for optimal flour grinding. Made from high-grade emery material, it ensures consistent performance and long service life for commercial and domestic flour mills.', 'Long lasting durability\nConsistent grinding quality\nLow maintenance\nEnergy efficient grinding', 'Domestic atta chakki\nSmall flour mills\nCommercial grinding units', 'Natraj Emery Stone 14 Inch | Pioneer Emery Stones', 'Buy Natraj 14 inch emery stone - premium quality flour mill stone from Pioneer.'),
(1, 'hi', 'नटराज इमेरी स्टोन 14 इंच', 'आटा चक्की के लिए प्रीमियम 14 इंच नटराज इमेरी स्टोन।', 'हमारा नटराज 14 इंच इमेरी स्टोन इष्टतम आटा पीसने के लिए सटीकता से बनाया गया है।', 'लंबे समय तक चलने वाला\nसुसंगत पीसने की गुणवत्ता\nकम रखरखाव', 'घरेलू आटा चक्की\nछोटी आटा चक्की', 'नटराज इमेरी स्टोन 14 इंच', 'नटराज 14 इंच इमेरी स्टोन खरीदें।'),
(2, 'en', 'Natraj Emery Stone 16 Inch', 'Heavy-duty 16 inch Natraj emery stone.', 'The Natraj 16 inch emery stone is designed for medium to large flour mills requiring high throughput and superior grinding efficiency.', 'High throughput\nSuperior grinding\nIndustrial grade quality', 'Medium flour mills\nIndustrial grinding', 'Natraj Emery Stone 16 Inch', 'Natraj 16 inch emery stone for medium flour mills.'),
(2, 'hi', 'नटराज इमेरी स्टोन 16 इंच', 'भारी-भरकम 16 इंच नटराज इमेरी स्टोन।', 'मध्यम से बड़ी आटा चक्की के लिए डिज़ाइन किया गया।', 'उच्च उत्पादन\nबेहतर पीसने की गुणवत्ता', 'मध्यम आटा चक्की', 'नटराज इमेरी स्टोन 16 इंच', 'मध्यम आटा चक्की के लिए नटराज 16 इंच।'),
(3, 'en', 'Surabhi Emery Stone 14 Inch', 'Reliable Surabhi 14 inch emery stone.', 'Surabhi emery stones are known for their balanced performance and affordability, making them ideal for small to medium flour mill operations.', 'Cost effective\nReliable performance\nEasy installation', 'Small flour mills\nAtta chakki dealers', 'Surabhi Emery Stone 14 Inch', 'Surabhi 14 inch emery stone supplier in India.'),
(3, 'hi', 'सुरभि इमेरी स्टोन 14 इंच', 'विश्वसनीय सुरभि 14 इंच इमेरी स्टोन।', 'संतुलित प्रदर्शन और किफायती कीमत के लिए जानी जाती है।', 'किफायती\nविश्वसनीय प्रदर्शन', 'छोटी आटा चक्की', 'सुरभि इमेरी स्टोन 14 इंच', 'भारत में सुरभि 14 इंच आपूर्तिकर्ता।'),
(4, 'en', 'Ravi Emery Stone 18 Inch', 'Industrial grade Ravi 18 inch emery stone.', 'The Ravi 18 inch emery stone is built for large-scale industrial flour milling operations with maximum output capacity.', 'Industrial grade\nMaximum output\nExtended service life', 'Large flour mills\nIndustrial units', 'Ravi Emery Stone 18 Inch', 'Ravi 18 inch industrial emery stone manufacturer.'),
(4, 'hi', 'रवि इमेरी स्टोन 18 इंच', 'औद्योगिक ग्रेड रवि 18 इंच इमेरी स्टोन।', 'बड़े पैमाने पर औद्योगिक आटा चक्की के लिए निर्मित।', 'औद्योगिक ग्रेड\nअधिकतम उत्पादन', 'बड़ी आटा चक्की', 'रवि इमेरी स्टोन 18 इंच', 'रवि 18 इंच औद्योगिक इमेरी स्टोन।'),
(5, 'en', 'Savaliya Emery Stone 16 Inch', 'Premium Savaliya 16 inch emery stone.', 'Savaliya emery stones deliver exceptional flour fineness and are preferred by quality-conscious mill operators across India.', 'Exceptional fineness\nPremium quality\nTrusted brand', 'Quality flour mills\nPremium atta production', 'Savaliya Emery Stone 16 Inch', 'Savaliya 16 inch emery stone from Pioneer.'),
(5, 'hi', 'सवलिया इमेरी स्टोन 16 इंच', 'प्रीमियम सवलिया 16 इंच इमेरी स्टोन।', 'असाधारण आटे की बारीकी प्रदान करता है।', 'उत्कृष्ट बारीकी\nप्रीमियम गुणवत्ता', 'गुणवत्ता आटा चक्की', 'सवलिया इमेरी स्टोन 16 इंच', 'पायनियर से सवलिया 16 इंच।');

INSERT INTO product_sizes (product_id, size_label, diameter, thickness, weight, sort_order) VALUES
(1, '14 Inch', '14"', '2.5"', '18 kg', 1),
(1, '16 Inch', '16"', '3"', '24 kg', 2),
(2, '16 Inch', '16"', '3"', '24 kg', 1),
(2, '18 Inch', '18"', '3.5"', '32 kg', 2),
(3, '14 Inch', '14"', '2.5"', '18 kg', 1),
(4, '18 Inch', '18"', '3.5"', '32 kg', 1),
(4, '20 Inch', '20"', '4"', '40 kg', 2),
(5, '16 Inch', '16"', '3"', '24 kg', 1);

INSERT INTO product_specs (product_id, spec_key, spec_value, lang, sort_order) VALUES
(1, 'Material', 'High Grade Emery', 'en', 1),
(1, 'Hardness', 'Superior', 'en', 2),
(1, 'Application', 'Flour Mill / Atta Chakki', 'en', 3),
(1, 'Origin', 'Rajasthan, India', 'en', 4),
(1, 'सामग्री', 'उच्च ग्रेड इमेरी', 'hi', 1),
(1, 'कठोरता', 'उत्कृष्ट', 'hi', 2);

-- Blog categories
INSERT INTO blog_categories (slug) VALUES
('emery-stone-guide'),
('flour-mill-tips'),
('business-guide');

INSERT INTO blog_category_translations (category_id, lang, name) VALUES
(1, 'en', 'Emery Stone Guide'), (1, 'hi', 'इमेरी स्टोन गाइड'),
(2, 'en', 'Flour Mill Tips'), (2, 'hi', 'आटा चक्की टिप्स'),
(3, 'en', 'Business Guide'), (3, 'hi', 'व्यवसाय गाइड');

-- Blogs
INSERT INTO blogs (category_id, slug, author, is_published, published_at) VALUES
(1, 'how-to-choose-emery-stones', 'Pioneer Team', 1, NOW()),
(2, 'flour-mill-maintenance-tips', 'Pioneer Team', 1, NOW()),
(1, 'best-emery-stones-for-atta-chakki', 'Pioneer Team', 1, NOW()),
(1, 'emery-stone-manufacturing-process', 'Pioneer Team', 1, NOW()),
(3, 'flour-mill-business-guide', 'Pioneer Team', 1, NOW()),
(1, 'industrial-grinding-solutions', 'Pioneer Team', 1, NOW());

INSERT INTO blog_translations (blog_id, lang, title, excerpt, content, meta_title, meta_description) VALUES
(1, 'en', 'How to Choose the Right Emery Stones for Your Flour Mill', 'A complete guide to selecting emery stones based on mill size, capacity, and grinding requirements.', '<p>Choosing the right emery stone is crucial for your flour mill performance. Consider factors like stone diameter, hardness, and brand reputation.</p><p>At Pioneer Emery Stones, we manufacture Natraj, Surabhi, Ravi, and Savaliya brands to meet every requirement.</p>', 'How to Choose Emery Stones | Pioneer Blog', 'Guide to choosing the best emery stones for flour mills.'),
(1, 'hi', 'अपनी आटा चक्की के लिए सही इमेरी स्टोन कैसे चुनें', 'चक्की के आकार और क्षमता के आधार पर इमेरी स्टोन चुनने की पूरी गाइड।', '<p>सही इमेरी स्टोन चुनना आपकी आटा चक्की के प्रदर्शन के लिए महत्वपूर्ण है।</p>', 'इमेरी स्टोन कैसे चुनें', 'आटा चक्की के लिए सर्वोत्तम इमेरी स्टोन चुनने की गाइड।'),
(2, 'en', 'Flour Mill Maintenance Tips for Longer Emery Stone Life', 'Essential maintenance practices to extend the life of your emery stones.', '<p>Regular cleaning, proper alignment, and timely dressing can significantly extend emery stone life.</p>', 'Flour Mill Maintenance Tips', 'Tips to maintain flour mill emery stones.'),
(2, 'hi', 'लंबे इमेरी स्टोन जीवन के लिए आटा चक्की रखरखाव टिप्स', 'इमेरी स्टोन की आयु बढ़ाने के लिए आवश्यक रखरखाव।', '<p>नियमित सफाई और उचित संरेखण इमेरी स्टोन की आयु बढ़ा सकता है।</p>', 'आटा चक्की रखरखाव टिप्स', 'इमेरी स्टोन रखरखाव के टिप्स।'),
(3, 'en', 'Best Emery Stones for Atta Chakki', 'Which emery stone brands work best for atta chakki machines?', '<p>Natraj and Surabhi emery stones are among the most popular choices for atta chakki across India.</p>', 'Best Emery Stones for Atta Chakki', 'Top emery stones for atta chakki machines.'),
(3, 'hi', 'आटा चक्की के लिए सर्वोत्तम इमेरी स्टोन्स', 'आटा चक्की मशीनों के लिए कौन से इमेरी स्टोन बेहतर हैं?', '<p>नटराज और सुरभि इमेरी स्टोन्स भारत भर में लोकप्रिय विकल्प हैं।</p>', 'आटा चक्की के लिए सर्वोत्तम इमेरी स्टोन्स', 'आटा चक्की के लिए शीर्ष इमेरी स्टोन्स।'),
(4, 'en', 'Emery Stone Manufacturing Process at Pioneer', 'Learn how we manufacture premium quality emery stones in Rajasthan.', '<p>Our manufacturing process involves careful selection of raw materials, precision shaping, and rigorous quality testing.</p>', 'Emery Stone Manufacturing Process', 'How Pioneer manufactures emery stones.'),
(4, 'hi', 'पायनियर में इमेरी स्टोन निर्माण प्रक्रिया', 'जानें कि हम राजस्थान में प्रीमियम इमेरी स्टोन्स कैसे बनाते हैं।', '<p>हमारी निर्माण प्रक्रिया में कच्चे माल का सावधानीपूर्वक चयन शामिल है।</p>', 'इमेरी स्टोन निर्माण प्रक्रिया', 'पायनियर इमेरी स्टोन्स कैसे बनाता है।'),
(5, 'en', 'Flour Mill Business Guide for Beginners', 'Start your flour mill business with the right equipment and emery stones.', '<p>Starting a flour mill business requires proper planning, quality emery stones, and reliable suppliers like Pioneer.</p>', 'Flour Mill Business Guide', 'Guide to starting a flour mill business in India.'),
(5, 'hi', 'शुरुआती के लिए आटा चक्की व्यवसाय गाइड', 'सही उपकरण और इमेरी स्टोन्स के साथ अपना व्यवसाय शुरू करें।', '<p>आटा चक्की व्यवसाय शुरू करने के लिए उचित योजना आवश्यक है।</p>', 'आटा चक्की व्यवसाय गाइड', 'भारत में आटा चक्की व्यवसाय शुरू करने की गाइड।'),
(6, 'en', 'Industrial Grinding Solutions with Pioneer Emery Stones', 'Heavy-duty emery stone solutions for industrial flour milling.', '<p>Our Ravi and Savaliya industrial grade stones handle high-capacity grinding with consistent results.</p>', 'Industrial Grinding Solutions', 'Industrial emery stone solutions from Pioneer.'),
(6, 'hi', 'पायनियर इमेरी स्टोन्स के साथ औद्योगिक पीसने के समाधान', 'औद्योगिक आटा चक्की के लिए भारी-भरकम इमेरी स्टोन समाधान।', '<p>हमारे औद्योगिक ग्रेड स्टोन्स उच्च क्षमता वाले पीसने को संभालते हैं।</p>', 'औद्योगिक पीसने के समाधान', 'पायनियर से औद्योगिक इमेरी स्टोन समाधान।');

INSERT INTO blog_tags (blog_id, tag) VALUES
(1, 'emery stone'), (1, 'flour mill'), (2, 'maintenance'), (3, 'atta chakki'), (4, 'manufacturing'), (5, 'business'), (6, 'industrial');

-- FAQs
INSERT INTO faqs (sort_order) VALUES (1),(2),(3),(4),(5),(6);

INSERT INTO faq_translations (faq_id, lang, question, answer) VALUES
(1, 'en', 'What are Emery Stones?', 'Emery stones are grinding stones used in flour mills and atta chakki machines to grind wheat and grains into fine flour. They are made from hard abrasive materials that provide efficient and consistent grinding.'),
(1, 'hi', 'इमेरी स्टोन्स क्या हैं?', 'इमेरी स्टोन्स आटा चक्की में गेहूं और अनाज को पीसने के लिए उपयोग की जाने वाली पीसने की पत्थर हैं।'),
(2, 'en', 'How long do Emery Stones last?', 'The lifespan of emery stones depends on usage, grain type, and maintenance. With proper care, Pioneer emery stones typically last 2-5 years in commercial operations.'),
(2, 'hi', 'इमेरी स्टोन्स कितने समय तक चलते हैं?', 'उचित देखभाल के साथ, पायनियर इमेरी स्टोन्स आमतौर पर 2-5 वर्ष तक चलते हैं।'),
(3, 'en', 'Which Emery Stone is best for flour mills?', 'Natraj and Ravi emery stones are popular for commercial flour mills, while Surabhi is ideal for small to medium operations. Contact us for personalized recommendations.'),
(3, 'hi', 'आटा चक्की के लिए कौन सा इमेरी स्टोन सबसे अच्छा है?', 'नटराज और रवि व्यावसायिक आटा चक्की के लिए लोकप्रिय हैं। व्यक्तिगत सिफारिश के लिए संपर्क करें।'),
(4, 'en', 'How to maintain Emery Stones?', 'Regular cleaning, proper stone dressing, correct alignment, and avoiding overloading help maintain emery stones and extend their service life.'),
(4, 'hi', 'इमेरी स्टोन्स का रखरखाव कैसे करें?', 'नियमित सफाई, उचित ड्रेसिंग और सही संरेखण इमेरी स्टोन्स के जीवन को बढ़ाता है।'),
(5, 'en', 'What sizes are available?', 'We offer emery stones in sizes ranging from 12 inch to 24 inch diameter. Custom sizes are also available on request.'),
(5, 'hi', 'कौन से आकार उपलब्ध हैं?', 'हम 12 इंच से 24 इंच व्यास तक के इमेरी स्टोन्स प्रदान करते हैं।'),
(6, 'en', 'Do you provide bulk orders?', 'Yes, Pioneer Emery Stones supplies bulk orders across India. We offer competitive pricing for dealers and distributors. Submit a dealer inquiry for wholesale rates.'),
(6, 'hi', 'क्या आप थोक ऑर्डर देते हैं?', 'हां, पायनियर इमेरी स्टोन्स पूरे भारत में थोक ऑर्डर की आपूर्ति करता है।');

-- Testimonials
INSERT INTO testimonials (type, name, company, location, rating, sort_order) VALUES
('customer', 'Rajesh Kumar', 'Kumar Flour Mill', 'Jaipur, Rajasthan', 5, 1),
('dealer', 'Amit Sharma', 'Sharma Trading Co.', 'Delhi', 5, 2),
('customer', 'Vikram Singh', 'Singh Atta Chakki', 'Udaipur, Rajasthan', 5, 3);

INSERT INTO testimonial_translations (testimonial_id, lang, review) VALUES
(1, 'en', 'Pioneer Natraj emery stones have transformed our flour mill output. Excellent quality and long-lasting performance. Highly recommended!'),
(1, 'hi', 'पायनियर नटराज इमेरी स्टोन्स ने हमारी आटा चक्की के उत्पादन को बदल दिया है। उत्कृष्ट गुणवत्ता!'),
(2, 'en', 'As a dealer, Pioneer has been our trusted partner for 10 years. Consistent quality, timely delivery, and great support.'),
(2, 'hi', 'एक डीलर के रूप में, पायनियर 10 वर्षों से हमारा विश्वसनीय साझीदार रहा है।'),
(3, 'en', 'The Surabhi emery stones we purchased are performing beyond expectations. Great value for money.'),
(3, 'hi', 'हमने जो सुरभि इमेरी स्टोन्स खरीदे वे अपेक्षाओं से बढ़कर प्रदर्शन कर रहे हैं।');

-- Page SEO
INSERT INTO page_seo (page_key, lang, meta_title, meta_description, meta_keywords) VALUES
('home', 'en', 'Pioneer Emery Stones - Emery Stone Manufacturer & Supplier India', 'Leading manufacturer of Natraj, Surabhi, Ravi & Savaliya Emery Stones for flour mills. 30+ years experience in Rajasthan, India.', 'Pioneer Emery Stones, Emery Stone Manufacturer, Flour Mill Emery Stone'),
('home', 'hi', 'Pioneer Emery Stones - इमेरी स्टोन निर्माता भारत', 'नटराज, सुरभि, रवि और सवलिया इमेरी स्टोन्स के अग्रणी निर्माता। राजस्थान, भारत में 30+ वर्षों का अनुभव।', 'पायनियर इमेरी स्टोन्स, इमेरी स्टोन निर्माता'),
('about', 'en', 'About Pioneer Emery Stones - 30+ Years Manufacturing Excellence', 'Learn about Pioneer Emery Stones - trusted emery stone manufacturer in Rajasthan with premium quality standards.', 'About Pioneer Emery Stones, Emery Stone Manufacturer Rajasthan'),
('about', 'hi', 'पायनियर इमेरी स्टोन्स के बारे में', 'राजस्थान में विश्वसनीय इमेरी स्टोन निर्माता के बारे में जानें।', 'पायनियर इमेरी स्टोन्स'),
('contact', 'en', 'Contact Pioneer Emery Stones - Get Quote Today', 'Contact Pioneer Emery Stones for emery stone inquiries, dealer partnerships, and bulk orders.', 'Contact Pioneer Emery Stones'),
('contact', 'hi', 'पायनियर इमेरी स्टोन्स से संपर्क करें', 'इमेरी स्टोन पूछताछ और थोक ऑर्डर के लिए संपर्क करें।', 'संपर्क पायनियर');
