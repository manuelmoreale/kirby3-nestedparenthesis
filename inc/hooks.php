<?php

# Return an array with all the custom actions attached to the hooks
return [
    
    # Fix the () nested inside the kirbytags
    'kirbytags:before' => function ($text, array $data = [], array $options = []) {

        # @rasteiner come up with this monster right here, don't blame me if your server explodes
        $regex = '/\((?:\w+:\s*(?\'rec\'(?>[^)(:\s]+)\s*|[:;]-?[)(]\s*|\(\s*(?&rec)*?\)\s*)+)+?\)/mx';

        # KirbyTags have not been parsed at this point
        $text = preg_replace_callback($regex, function ($matches) {
            
            # Return the string with swapped characters
            return '(' . str_replace(['(',')'] , ['⎣','⎦'] , substr($matches[0],1,-1)) . ')';

        }, $text);

        return $text;
    },

    # Add back the () we swapped previously
    'kirbytags:after' => function ($text, array $data = [], array $options = []) {
        $text = str_replace(['⎣','⎦'] , ['(',')'] , $text);
        return $text;
    }
];