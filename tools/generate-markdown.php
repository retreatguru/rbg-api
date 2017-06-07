<?php

/**
 * 
 * This script validates a Swagger YAML definition according to the Swagger 2.0 schema
 * and generates Markdown documentation from the API definition.
 *
 * It's very limited in application and only implements the constructs we are using
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
    $result = true;
    if (! $validator->isValid()) {
        error_log('Errors found in API definition:');
        foreach ($validator->getErrors() as $error) {
            error_log(sprintf('[%s] %s', $error['property'], $error['message']));
            $result = false;
        }
    }
    return $result;
}

/**
 * Parses a $ref reference in Swagger and returns a markdown link.
 */
function _parse_ref($object) {
    $arr = (array)$object;
    $name = str_replace('#/definitions/', '', $arr['$ref']);
    return "[$name](#".strtolower($name).')';
}

/**
 * Parses type definition and returns markdown text describing it.
 */
function _parse_type($field) {
    if ($field->type == 'array') {
        if (isset($field->items->type)) {
            return '['.$field->items->type.']';
        } else {
            return 'array';
        }
    } else {
        if (isset($field->format)) {
            return $field->format;
        } else {
            return $field->type;
        }
    }
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
        echo "\n---\n\n";

        foreach ($methods as $method => $methodInfo) {
            $method = strtoupper($method);
            echo "### $method {$path}\n";
            echo "**{$methodInfo->summary}**\n\n";
            echo "$methodInfo->description\n";
            echo "#### Parameters\n\n";

            foreach ($methodInfo->parameters as $parameter) {
                $parameterArray = (array)$parameter;
                if (isset($parameterArray['$ref'])) {
                    $parameterName = str_replace('#/parameters/', '', $parameterArray['$ref']);
                    $parameter = $spec->parameters->$parameterName;
                }
                $required = (isset($parameter->required) ? ' (required)' : '');
                $type = _parse_type($parameter);
                echo "***$parameter->name: $type$required***\n\n";
                echo trim($parameter->description)."\n\n";
            }

            echo "#### Responses\n\n";
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

    echo "\n## Models\n";

    // generate model descriptions
    foreach ($spec->definitions as $name => $definition) {
        echo "\n### $name\n\n";
        echo trim($definition->description)."\n";
        echo "\n";

        echo "#### Properties\n\n";

        echo "| Name | Type | Description |\n";
        echo "| ---- |----- | ----------- |\n";

        foreach ($definition->properties as $propName => $property) {
            $type = _parse_type($property);
            $description = $property->description;
            if (isset($property->enum)) {
                $description .= ' ('.implode(', ', $property->enum).')';
            }
            echo "| $propName | $type | $description |\n";
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
    $result = validate($spec);
    if ($result) {
        generate_markdown($spec);
    } else {
        exit(1);
    }
}

main();