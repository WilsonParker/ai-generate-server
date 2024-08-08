<?php

return [
    'prompt' => '((dressed)), $people $gender, $race, $prompt, RAW photo, (high detailed skin:1.2), 8k uhd, dslr, soft lighting, high quality, film grain, <lora:vodka_portraits:$lora>',
    'negative' => '(multiple subjects), (deformed iris, deformed pupils, semi-realistic, cgi, 3d, render, sketch, cartoon, drawing, anime:1.4), text, close up, cropped, out of frame, worst quality, low quality, jpeg artifacts, ugly, duplicate, morbid, mutilated, extra fingers, mutated hands, poorly drawn hands, poorly drawn face, mutation, deformed, blurry, dehydrated, bad anatomy, bad proportions, extra limbs, cloned face, disfigured, gross proportions, malformed limbs, missing arms, missing legs, extra arms, extra legs, fused fingers, too many fingers, long neck, poorly drawn, wrong anatomy, extra limb, missing limb, floating limbs, disconnected limbs, mutated, disgusting, amputation, (nsfw), nude, weird smart phone, weird mobile',
    'image_generate_callback_url' => env('IMAGE_GENERATE_CALLBACK_URL'),
    'default' => '',
];
