<?php
/**
 * @file
 * Contains \Drupal\calculator\Entity\Feedback.
 */
namespace Drupal\calculator\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Feedback entity.
 *
 * @ingroup feedback
 *
 * @ContentEntityType(
 *   id = "feedback",
 *   label = @Translation("Feedback"),
 *   base_table = "feedback",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class Feedback extends ContentEntityBase implements ContentEntityInterface {
	public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
		// Standard field, used as unique if primary index.
		$fields['id'] = BaseFieldDefinition::create('integer')
			->setLabel(t('ID'))
			->setDescription(t('The ID of the Feedback entity.'))
			->setReadOnly(TRUE);

		$fields['rating'] = BaseFieldDefinition::create('integer')
			->setLabel(t("The user's rating star"))
			->setDescription(t('1~5 star'))
			->setRequired(TRUE)
			->setSettings(array(
				'default_value' => 5
			));

		$fields['recommend'] = BaseFieldDefinition::create('boolean')
			->setLabel(t("Will user recommend?"))
			->setDescription(t('yes or no'))
			->setRequired(TRUE)
			->setSettings(array(
				'default_value' => TRUE
			));

		$fields['comment'] = BaseFieldDefinition::create('string')
			->setLabel(t("user comment"))
			->setDescription(t('yes or no'))
			->setRequired(TRUE)
			->setSettings(array(
				'default_value' => '',
				'max_length' => 255
			));

		return $fields;
	}

}