<?php

# Return an array with all the custom actions attached to the hooks
return [
    
    # Fix the () nested inside the kirbytags
    'kirbytags:before' => function ($text, array $data = [], array $options = []) {

        # @rasteiner come up with this monster right here, don't blame me if your server explodes
        $regex = '/\(\s*(\w+?):\s*?\w+?\s*?(?:\w+?:(?\'rec\'[:;]-?[\(\)]|[^)(]+?|\((?&rec)*?\))*?)*?\)/mx';

        # KirbyTags have not been parsed at this point
        $text = preg_replace_callback($regex, function ($matches) {
            
            # Loop through each tag and perform a replace
            foreach ($matches as $match) :

                # First trim the () at the beginning and at the end of the tag,
                # because we want to keep those
                $match = substr($match , 1 , -1);

                # Then look for () inside the string and replace them with another character
                $match = str_replace(['(',')'] , ['⎣','⎦'] , $match);

                # Add back the two () at the beginning and the end
                $match = "({$match})";

                # Return the string
                return $match;

            endforeach;

            # Return al the kirbytags
            return $matches;

        }, $text);

        return $text;
    },

    # Add back the () we swapped previously
    'kirbytags:after' => function ($text, array $data = [], array $options = []) {
        $text = str_replace(['⎣','⎦'] , ['(',')'] , $text);
        return $text;
    }
];