<?php

/**
 * 
 * This script validates a Swagger YAML definition according to the Swagger 2.0 schema
 * and generates Markdown documentation from the API definition.
 *
 * It's very limited in application and only implements that constructs we are using
 * for our API, but allows us full control over how the generated documentation looks,
 * which is arguably worth it.
 * 
 */

require_once 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use JsonSchema\Validator;

/**
 * Loads a Swagger YAML file.
 */
function load($url)
{
    $spec = Yaml::parse(file_get_contents($url));
    return json_decode(json_encode($spec));
}

/**
 * Validates a Swagger API definition against the official Swagger JSON schema.
 * Errors aren't the most helpful, but at least it keeps us honest.
 */
function validate($spec) {
    $validator = new Validator;
    $validator->validate($spec, (object)['$ref' => 'file://'.dirname(__FILE__).'/swagger-schema-v2.json']);
    if (! $validator->isValid()) {
        foreach ($validator->getErrors() as $error) {
            error_log(sprintf('[%s] %s', $error['property'], $error['message']));
        }
    }
}

function _parse_ref($object) {
    $arr = (array)$object;
    $name = str_replace('#/definitions/', '', $arr['$ref']);
    return "[$name](#definitions-$name)";
}

/**
 * Generates a Markdown document from the Swagger API definition.
 */
function generate_markdown($spec) {
    $title = "{$spec->info->title} {$spec->info->version}";
    
    echo "$title\n";
    echo str_repeat('=', strlen($title))."\n";
    echo "\n";

    echo "{$spec->info->description}";

    // generate endpoint descriptions
    foreach ($spec->paths as $path => $methods) {
        echo "### {$path}\n";
        echo "\n---\n\n";

        foreach ($methods as $method => $methodInfo) {
            $method = strtoupper($method);
            echo "#### *$method*\n\n";
            echo "##### {$methodInfo->summary}\n\n";
            echo "$methodInfo->description\n";
            echo "##### Parameters\n\n";

            foreach ($methodInfo->parameters as $parameter) {
                $required = (isset($parameter->required) ? '[required]' : '');
                $type = $parameter->type == 'array' ? '['.$parameter->items->type.']' : $parameter->type;
                echo "**`$parameter->name: $type$required`**\n";
                echo str_replace("\n", ' ', $parameter->description)."\n\n";
            }

            echo "##### Responses\n\n";
            echo "| Code | Description | Schema |\n";
            echo "| ---- | ----------- | ------ |\n";

            foreach ($methodInfo->responses as $code => $responseInfo) {
                if (isset($responseInfo->schema->type) && $responseInfo->schema->type == 'array') {
                    $schema = '[ '._parse_ref($responseInfo->schema->items).' ]';
                } else {
                    $schema = _parse_ref($responseInfo->schema);
                }
                $schema = str_replace('#/definitions/', '', $schema);
                echo "$code | $responseInfo->description | $schema \n";
            }
        }
    }

    // generate model descriptions
    echo "\n### Models\n\n";
    foreach ($spec->definitions as $name => $definition) {
        echo "<a name='definitions-$name'></a>\n";
        echo "#### $name\n\n";
        echo "$definition->description\n";
        echo "\n";

        echo "##### Properties\n\n";

        foreach ($definition->properties as $propName => $property) {
            $required = (isset($property->required) ? '[required]' : '');
            $type = $property->type == 'array' ? '['.$property->items->type.']' : $property->type;
            echo "**`$propName: $type$required`**\n\n";
            echo str_replace("\n", ' ', $property->description)."\n\n";
        }
    }
}

/**
 * Main entrypoint.
 */
function main() {
    global $argv;

    if (count($argv) < 2) {
        error_log("usage: $argv[0] <swagger-file>");
        exit(1);
    }

    $spec = load($argv[1]);
    validate($spec);
    generate_markdown($spec);
}

main();